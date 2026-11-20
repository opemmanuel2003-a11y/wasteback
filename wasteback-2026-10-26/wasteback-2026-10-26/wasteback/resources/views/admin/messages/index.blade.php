@extends('layouts.portal', ['title' => 'Messages'])

@section('heading', 'Messages')
@section('subheading', 'Enquiries sent through the website contact form.')

@section('content')
<section class="panel">
    @forelse ($messages as $message)
        <div class="panel-body" style="border-bottom:1px solid var(--line)">
            <div class="gap-row" style="justify-content:space-between;align-items:flex-start">
                <div>
                    <div class="gap-row"><strong>{{ $message->subject }}</strong> @unless ($message->is_read)<span class="status status-unread">New</span>@endunless</div>
                    <small class="muted">{{ $message->name }}, <a href="tel:{{ $message->phone }}">{{ $message->phone }}</a>{{ $message->email ? ', '.$message->email : '' }}. {{ $message->created_at->format('j M Y, H:i') }}</small>
                    <p class="mb-0" style="margin-top:10px">{{ $message->message }}</p>
                </div>
                @unless ($message->is_read)
                    <form method="POST" action="{{ route('admin.messages.read', $message) }}">
                        @csrf @method('PATCH')
                        <button class="btn btn-sm btn-outline" type="submit"><x-icon name="check" size="15" /> Mark read</button>
                    </form>
                @endunless
            </div>
        </div>
    @empty
        <div class="empty"><x-icon name="inbox" size="40" /><p class="mb-0">No messages yet.</p></div>
    @endforelse
    <x-pager :items="$messages" />
</section>
@endsection
