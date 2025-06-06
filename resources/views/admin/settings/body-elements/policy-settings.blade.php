<div class="tab-pane fade" id="v-pills-policy" role="tabpanel" aria-labelledby="v-pills-policy-tab">
    <div class="row g-4">
        <div class="col-12">
            <div class="trk-card shadow">
                    <div class="trk-card__wrapper">
                        <div class="trk-card__header text-center">
                            <h5>{{ __('default.policy_setting') }}</h5>
                        </div>
                        <div class="trk-card__body">
                            <form class="form" action="{{ route('admin.policy.settings.update', 1) }}" method="post"
                                    enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')
                                    <div class="row g-4">

                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="form-label" for="about_us">{{ __('field.about_us') }}</label>
                                                {!!renderCKEditorHtml('about_us',0,$data['about_us'] ?? '')!!}
                                                @error('about_us')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="form-label" for="privacy_policy">{{ __('field.privacy_policy') }}</label>
                                                {!!renderCKEditorHtml('privacy_policy',0,$data['privacy_policy'] ?? '')!!}
                                                @error('privacy_policy')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="form-label" for="copyright_policy">{{ __('field.copyright_policy') }}</label>
                                                {!!renderCKEditorHtml('copyright_policy',0,$data['copyright_policy'] ?? '')!!}
                                                @error('copyright_policy')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="text-end">
                                            <button type="reset" class="btn btn-danger mt-4">{{ __('button.reset') }}</button>
                                            <button type="submit" class="btn btn-primary mt-4">{{ __('button.update') }}</button>
                                        </div>

                                    </div>
                                </form>

                        </div>
                    </div>
            </div>
        </div>
    </div>
</div>
