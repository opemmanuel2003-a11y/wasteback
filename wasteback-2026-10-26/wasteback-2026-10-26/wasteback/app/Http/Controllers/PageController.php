<?php

namespace App\Http\Controllers;

use App\Models\ContactMessage;
use App\Models\Material;
use App\Models\PickupItem;
use App\Models\User;
use App\Models\WalletTransaction;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PageController extends Controller
{
    public function home(): View
    {
        return view('pages.home', [
            'materials' => Material::where('is_active', true)->orderBy('price_per_kg', 'desc')->take(3)->get(),
            'stats' => $this->stats(),
            'faqs' => $this->faqs(),
        ]);
    }

    public function about(): View
    {
        return view('pages.about', ['stats' => $this->stats()]);
    }

    public function services(): View
    {
        return view('pages.services');
    }

    public function prices(): View
    {
        return view('pages.prices', [
            'materials' => Material::where('is_active', true)->orderBy('category')->orderBy('name')->get(),
        ]);
    }

    public function howItWorks(): View
    {
        return view('pages.how', ['faqs' => $this->faqs()]);
    }

    public function contact(): View
    {
        return view('pages.contact');
    }

    public function sendMessage(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'email' => ['nullable', 'email', 'max:150'],
            'phone' => ['required', 'string', 'max:20', 'regex:/^[0-9+\s]{9,20}$/'],
            'subject' => ['required', 'string', 'max:150'],
            'message' => ['required', 'string', 'max:3000'],
        ], ['phone.regex' => 'Enter a valid phone number, for example 0772 123 456.']);

        ContactMessage::create($data);

        return back()->with('success', 'Thank you. Your message has reached our team and we will call you back.');
    }

    /** @return array<string, float|int> */
    private function stats(): array
    {
        return [
            'kg' => (float) PickupItem::whereHas('pickup', fn ($q) => $q->where('status', 'collected'))->sum('verified_kg'),
            'households' => User::where('role', 'household')->count(),
            'paid' => (float) WalletTransaction::where('type', 'credit')->sum('amount'),
            'agents' => User::where('role', 'agent')->where('is_active', true)->count(),
        ];
    }

    /** @return array<int, array{q: string, a: string}> */
    private function faqs(): array
    {
        return [
            ['q' => 'What materials do you buy?', 'a' => 'Plastic bottles and containers, metal scrap such as aluminium cans and iron, paper and cardboard, glass bottles and small electronic scrap. The full list and prices are on the Prices page.'],
            ['q' => 'How is my payment calculated?', 'a' => 'You get an estimate when you book. On the day, the field agent weighs each material with a scale in front of you, and you are paid the verified weight multiplied by the price per kilogram that was shown when you booked.'],
            ['q' => 'When do I receive my money?', 'a' => 'As soon as the agent confirms the collection, the amount is credited to your WasteBack wallet. You can then withdraw to MTN Mobile Money or Airtel Money. In this project version the withdrawals are simulated.'],
            ['q' => 'Is there a minimum quantity?', 'a' => 'No minimum for booking, but we recommend collecting at least 5 kg so the trip is worth it for you. The minimum wallet withdrawal is UGX 2,000.'],
            ['q' => 'Which areas do you cover?', 'a' => 'We start in Banda and neighbouring areas of Kampala and Wakiso such as Kyambogo, Kireka, Nakawa, Ntinda, Kiwatule and Bweyogerere.'],
            ['q' => 'How should I sort my waste?', 'a' => 'Keep plastics, metals, paper and glass in separate bags, rinse bottles and containers, and keep paper dry. Food and garden waste is not bought.'],
        ];
    }
}
