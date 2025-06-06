<div class="tab-pane fade show active" id="v-pills-general-settings" role="tabpanel" aria-labelledby="v-pills-general-settings-tab">
    <div class="row g-4">
        <div class="col-12">
            <div class="trk-card shadow">
                    <div class="trk-card__wrapper">
                        <div class="trk-card__header text-center">
                            <h5>{{ __('default.general_setting') }}</h5>
                        </div>
                        <div class="trk-card__body">

                            <form class="form" action="{{ route('admin.settings.update', 1) }}" method="post"
                                    enctype="multipart/form-data">
                                    @csrf
                                    @method('put')

                                    <div class="row g-4">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label" for="light_logo">Light Logo</label>
                                                <div class="admin__thumb-upload">
                                                    <div class=" admin__thumb-edit">
                                                        <input type='file' id="light_logo" name="light_logo" onchange="imagePreview(this,'imagePreview');"
                                                            accept=".png, .jpg, .jpeg" />
                                                        <label class="form-label" for="light_logo"></label>
                                                    </div>
                                                    <div class="admin__thumb-preview">
                                                        <div id="imagePreview" class="admin__thumb-profilepreview"
                                                            style="background-image: url({{ isset($data['light_logo']) && $data['light_logo']? asset($data['light_logo']):'' }});">
                                                        </div>
                                                    </div>
                                                </div>
                                                @error('light_logo')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>


                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label" for="dark_logo">Dark Logo</label>
                                                <div class="admin__thumb-upload">
                                                    <div class=" admin__thumb-edit">
                                                        <input type='file' id="dark_logo" name="dark_logo" onchange="imagePreview(this,'imagePreview');"
                                                            accept=".png, .jpg, .jpeg" />
                                                        <label class="form-label" for="dark_logo"></label>
                                                    </div>
                                                    <div class="admin__thumb-preview">
                                                        <div id="imagePreview" class="admin__thumb-profilepreview"
                                                            style="background-image: url({{ isset($data['dark_logo']) && $data['dark_logo']? asset($data['dark_logo']):'' }});">
                                                        </div>
                                                    </div>
                                                </div>
                                                @error('dark_logo')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        
                                    <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label" for="favicon">{{ __('field.favicon') }}</label>
                                                <div class="admin__thumb-upload">
                                                    <div class=" admin__thumb-edit">
                                                        <input type='file' id="favicon" name="favicon" onchange="imagePreview(this,'favImagePreview');"
                                                            accept=".png, .jpg, .jpeg" />
                                                        <label class="form-label" for="favicon"></label>
                                                    </div>
                                                    <div class="admin__thumb-preview">
                                                        <div id="favImagePreview" class="admin__thumb-profilepreview"
                                                            style="background-image: url({{ isset($data['favicon']) && $data['favicon'] ? asset($data['favicon']):'' }});">
                                                        </div>
                                                    </div>
                                                </div>
                                                @error('favicon')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label" for="title">{{ __('field.title') }}</label>
                                                <input type="text" class="form-control @error('title') is-invalid @enderror"
                                                    id="title" name="title" value="{{ $data['title'] ?? '' }}" />
                                                @error('title')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label" for="email">{{ __('field.email') }}</label>
                                                <input type="email" class="form-control @error('email') is-invalid @enderror"
                                                    id="email" name="email" value="{{ $data['email'] ?? '' }}" />
                                                @error('email')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label" for="phone">{{ __('field.phone') }}</label>
                                                <input type="text" class="form-control @error('phone') is-invalid @enderror"
                                                    id="phone" name="phone" value="{{ $data['phone'] ?? '' }}" />
                                                @error('phone')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label" for="address">{{ __('field.address') }}</label>
                                                <input type="text"
                                                    class="form-control @error('address') is-invalid @enderror" id="address"
                                                    name="address" value="{{ $data['address'] ?? '' }}" />
                                                @error('address')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="form-label" for="meta_title">{{ __('field.meta_title') }}</label>
                                                <input type="text"
                                                    class="form-control @error('meta_title') is-invalid @enderror"
                                                    id="meta_title" name="meta_title" value="{{ $data['meta_title'] ?? '' }}">
                                                @error('meta_title')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="form-label" for="meta_description">{{ __('field.meta_description') }}</label>
                                                {!!renderCKEditorHtml('meta_description',0,$data['meta_description'] ?? '')!!}
                                                @error('meta_description')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="text-end">
                                        <button type="reset" class="btn btn-danger mt-4">{{ __('button.reset') }}</button>
                                        <button type="submit" class="btn btn-primary mt-4">{{ __('button.update') }}</button>
                                    </div>

                                </form>
                        </div>
                    </div>
            </div>
        </div>
    </div>
</div>
