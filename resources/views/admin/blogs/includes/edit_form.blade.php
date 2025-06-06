<form class="form" action="{{ route($info->form_route, $id) }}" method="post"
    enctype="multipart/form-data">
    @method('PUT')
    @csrf
    <div class="row g-4">

        <div class="col-md-6">

            <div class="form-group">

                <label class="form-label" for="banner">Banner
                </label>
                <div class="admin__thumb-upload">
                    <div class=" admin__thumb-edit">
                        <input type='file' class="@error('banner') is-invalid @enderror"
                            id="banner" name="banner"
                            onchange="imagePreview(this,'image_preview_banner');"
                            accept=".png, .jpg, .jpeg" />
                        <label for="banner"></label>
                    </div>

                    <div class="admin__thumb-preview">
                        <div id="image_preview_banner" class="admin__thumb-profilepreview"
                            style="
    background-image: url({{ $data->banner != '' ? asset($data->banner) : asset(avatarUrl()) }});">
                        </div>
                    </div>

                    @error('banner')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>




            </div>

        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label class="form-label" for="title">Title <span>&#x002A;</span> </label>
                <input type="text" value="{{ $data->title }}"
                    class="form-control @error('title') is-invalid @enderror" id="title"
                    name="title" placeholder="Enter Title" required>
                @error('title')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <label class="form-label" for="slug">Slug <span>&#x002A;</span> </label>
                <input type="text" value="{{ $data->slug }}"
                    class="form-control @error('slug') is-invalid @enderror" id="slug"
                    name="slug" placeholder="Enter Slug" required>
                @error('slug')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="col-md-6">

            <div class="form-group">
                <label class="form-label" for="blog_category_id">Blog Category <span>&#x002A;</span>
                </label>
                <select
                    class="form-select search-select @error('blog_category_id') is-invalid @enderror"
                    data-live-search="true" id="blog_category_id" name="blog_category_id" required>
                    <option value="">--Choose--</option>
                    @foreach (activeModelData('App\Models\BlogCategory') as $row)
                        <option value="{{ $row->id }}"
                            @if ($data->blog_category_id == $row->id) selected @endif>{{ $row->title }}
                        </option>
                    @endforeach
                </select>
                @error('blog_category_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

        </div>
        <div class="col-md-6">

            <div class="form-group">
                <label class="form-label" for="status">Status <span>&#x002A;</span> </label>
                <select class="form-select search-select @error('status') is-invalid @enderror"
                    data-live-search="true" id="status" name="status" required>
                    <option value="">--Choose--</option>

                    <option value="draft" @if ($data->status == 'draft') selected @endif>Draft
                    </option>

                    <option value="published" @if ($data->status == 'published') selected @endif>
                        Published</option>
                </select>
                @error('status')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

        </div>
        <div class="col-md-12">

            <div class="form-group">

                <label class="form-label" for="short_description">Short Description </label>
                {!! renderCKEditorHtml('short_description', 0, $data->short_description) !!} @error('short_description')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

        </div>
        <div class="col-md-12">

            <div class="form-group">

                <label class="form-label" for="description">Description </label>
                {!! renderCKEditorHtml('description', 0, $data->description) !!} @error('description')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

        </div>


        <div class="col-md-6">
            <div class="form-group">
                <label class="form-label" for="meta_title">Meta Title </label>
                <input type="text" value="{{ $data->meta_title }}"
                    class="form-control @error('meta_title') is-invalid @enderror" id="meta_title"
                    name="meta_title" placeholder="Enter Meta Title">
                @error('meta_title')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <label class="form-label" for="meta_tags">Meta Tag </label>
                <input type="text" value="{{ $data->meta_tags }}"
                    class="form-control @error('meta_tags') is-invalid @enderror" id="meta_tags"
                    name="meta_tags" placeholder="Enter Meta Tag">
                @error('meta_tags')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        
        <div class="col-md-12">

            <div class="form-group">

                <label class="form-label" for="meta_description">Meta Description </label>
                {!! renderCKEditorHtml('meta_description', 0, $data->meta_description) !!} @error('meta_description')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

        </div>

    </div>
    <div class="row">
        <div class="col-lg-10">
            <button type="submit"
                class="btn btn-primary mt-4">{{ __('button.update') }}</button>
            <button type="reset" class="btn btn-danger mt-4">{{ __('button.reset') }}</button>
        </div>
    </div>
</form>