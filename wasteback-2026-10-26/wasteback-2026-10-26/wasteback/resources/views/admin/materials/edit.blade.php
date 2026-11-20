@extends('layouts.portal', ['title' => 'Edit '.$material->name])

@section('heading', 'Edit '.$material->name)

@section('content')
<form method="POST" action="{{ route('admin.materials.update', $material) }}" class="panel" style="max-width:820px">
    @csrf @method('PUT')
    <div class="panel-head"><h2>Material details</h2><img src="{{ img($material->image ?: 'bottles', 120, 80) }}" alt="" style="border-radius:10px;height:44px"></div>
    @include('admin.materials.fields')
    <div class="panel-body gap-row" style="padding-top:0">
        <label class="check"><input type="checkbox" name="is_active" value="1" @checked(old('is_active', $material->is_active))> Accept this material in new bookings</label>
    </div>
    <div class="panel-body gap-row" style="padding-top:0">
        <button class="btn btn-lime" type="submit">Save Changes</button>
        <a href="{{ route('admin.materials.index') }}" class="btn btn-outline">Cancel</a>
    </div>
</form>
@endsection
