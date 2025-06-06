<div class="tab-pane fade" id="v-pills-email_setting" role="tabpanel" aria-labelledby="v-pills-email_setting-tab">
    <div class="row g-4">
        <div class="col-12">
            <div class="trk-card shadow">
                <div class="trk-card__wrapper">
                    <div class="trk-card__header text-center">
                        <h5>{{ __('default.email_setting') }}</h5>
                    </div>
                    <div class="trk-card__body">
                        <form class="form" action="{{ route('admin.email.send') }}" method="post"
                            enctype="multipart/form-data">
                            @csrf

                            <div class="row g-4">

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <select class="form-select search-select" id="driver" name="driver">
                                            <option value="">--Choose a provider--</option>
                                            <option value="smtp">SMTP</option>
                                            <option value="amazon_ses">Amazon SES</option>
                                            <option value="mailgun">Mailgun</option>
                                            <option value="sendmail">Sendmail</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label" for="fromEmail">{{ __('field.from_address') }}</label>
                                        <input type="email" class="form-control" id="fromEmail"
                                            name="MAIL_FROM_ADDRESS" value="{{ getEnv('MAIL_FROM_ADDRESS') }}" />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label" for="fromName">{{ __('field.from_name') }}</label>
                                        <input type="fromName" class="form-control" id="fromName" name="MAIL_FROM_NAME"
                                            value="{{ getEnv('MAIL_FROM_NAME') }}" />
                                    </div>
                                </div>

                                <div id="form-container"></div>

                            </div>
                            <div class="row">
                                <div class="col-lg-10">
                                    <button type="submit"
                                        class="btn btn-primary mt-4">{{ __('button.update') }}</button>
                                    <button type="reset" class="btn btn-danger mt-4">{{ __('button.reset') }}</button>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
