{{-- Image upload widget for admin edit forms: preview + upload + clear. --}}
<div class="img-upload" style="display:flex;flex-wrap:wrap;gap:14px;align-items:center;margin:10px 0 22px;padding:14px;border:1px dashed var(--line,#c8c2b2);border-radius:14px">
    @if ($model->image)
        <img src="{{ asset($model->image) }}" alt="" style="width:132px;height:88px;object-fit:cover;border-radius:10px">
    @else
        <div style="width:132px;height:88px;border-radius:10px;background:var(--soft,#efe9d8);display:flex;align-items:center;justify-content:center;color:var(--muted,#6b6552);font-size:11px">{{ __('ui.admin.no_image') }}</div>
    @endif
    <div style="display:flex;flex-direction:column;gap:8px">
        <form method="post" action="{{ $upload }}" enctype="multipart/form-data" style="display:flex;gap:8px;align-items:center;flex-wrap:wrap">
            @csrf
            <input type="file" name="image" accept="image/jpeg,image/png,image/webp" required style="font-size:13px">
            <button class="btn small" type="submit">{{ __('ui.admin.image_upload') }}</button>
        </form>
        @if ($model->image)
            <form method="post" action="{{ $remove }}">
                @csrf @method('delete')
                <button class="btn btn-ghost small danger" type="submit">{{ __('ui.admin.image_remove') }}</button>
            </form>
        @endif
        <span class="muted small" style="font-size:11px">{{ __('ui.admin.image_upload_help') }}</span>
    </div>
</div>
