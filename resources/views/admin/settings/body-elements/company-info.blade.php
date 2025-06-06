<div class="tab-pane fade" id="v-pills-company-info" role="tabpanel" aria-labelledby="v-pills-company-info-tab">
    <div class="row g-4">
        <div class="col-12">
            <div class="trk-card shadow">
                    <div class="trk-card__wrapper">
                        <div class="trk-card__header text-center">
                            <h5>{{ __('default.company_info') }}</h5>
                        </div>
                        <div class="trk-card__body">

                            <form class="form" method="POST" action="{{route('admin.company.info.settings.update')}}" enctype="multipart/form-data">
                                @csrf
                                @method('put')
                                <div class="row g-4">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="form-label" for="name">{{ __('field.name') }}</label>
                                            <input type="text" class="form-control"  name="company_name" value="{{$data['company_name']?? ''}}">
                                            @error('name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="form-label" for="email11">{{ __('field.email_address') }}</label>
                                            <input type="email" class="form-control" name="company_email" value="{{$data['company_email']?? ''}}">
                                            <span class="text-muted py-2 ms-1">{{ __('message.email_will_not_be_publicly_displayed') }}.
                                                <a href="#">{{ __('default.learn_more') }}</a>.</span>
                                            @error('email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="form-label" for="language">{{ __('default.language') }}</label>
                                            <select class="form-select search-select" name="company_language">
                                                @foreach(languageArray() as $language)
                                                <option value="{{$language}}" @if(isset($data['company_language']) && $data['company_language']==$language) selected="selected" @endif>
                                                    {{$language}}
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="form-label" for="time_zone">{{ __('default.time_zone') }}</label>
                                            <select class="form-select search-select" name="company_time_zone">
                                                @foreach(timeZoneArray() as $time)
                                                <option value="{{$time}}" @if(isset($data['company_time_zone']) && $data['company_time_zone']==$time) selected="selected" @endif>
                                                    {{$time}}
                                                </option>
                                                @endforeach
                                            </select>
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