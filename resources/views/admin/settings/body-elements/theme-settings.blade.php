<div class="tab-pane fade" id="v-pills-theme-setting" role="tabpanel"
    aria-labelledby="v-pills-theme-setting-tab">
    <div class="row g-4">
    <div class="col-12">
        <div class="trk-card shadow">
        <div class="trk-card__wrapper">
            <div class="trk-card__header text-center">
            <h5>Theme Setting</h5>
            </div>
            <div class="trk-card__body">
                <form class="form" action="{{ route('admin.theme.settings.update') }}" method="post">
                @csrf
                @method('PUT')
                <div class="row g-4">
                    <div class="col-12">
                        <h6 class="fs-5 fw-medium ">Sidebar Theme</h6>
                        <div class="d-flex flex-wrap gap-4">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="sidebar_theme"
                            id="sidebar-light" value="light" @if(isset($data['sidebar_theme']) && $data['sidebar_theme']=='light') checked @endif>
                            <label class="form-check-label" for="sidebar-light">Light</label>
                        </div>
    
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="sidebar_theme"
                            id="sidebar-dark" value="dark" @if(isset($data['sidebar_theme']) && $data['sidebar_theme']=='dark') checked @endif>
                            <label class="form-check-label" for="sidebar-dark">Dark</label>
                        </div>
                        </div>
                    </div>
                    <div class="col-12">
                      <div class="from-group">
                        <label class="form-label" for="theme">logo Position </label>
                        <div class="d-flex flex-wrap gap-4 ">
                          <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="logo"
                              id="logo-left" value="left" checked>
                            <label class="form-check-label" for="logo-left">Left</label>
                          </div>
                          <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="logo"
                              id="logo-center" value="center">
                            <label class="form-check-label" for="logo-center">Center</label>
                          </div>
                          <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="logo"
                              id="logo-right" value="right">
                            <label class="form-check-label" for="logo-right">Right</label>
                          </div>
                        </div>
                      </div>
                    </div>
                    <!-- Color Scheme -->
                    <div class="col-12">
                      <div class="from-group">
                        <label class="form-label" for="theme">Color Scheme </label>
                        <div class="row g-4">
                          <div class="col-md-4">
                            <div class="form-group d-flex align-items-center gap-2">
                              <input type="color" class="form-control form-control-color"
                              id="brand-color" name="brand-color" value="#6D71FA">
                              <label for="brand-color" class="form-label"> Brand Color</label>
                            </div>
                          </div>
                          <div class="col-md-4">
                            <div class="form-group d-flex align-items-center gap-2">
                              <input type="color" class="form-control form-control-color"
                              id="secondary-color" name="secondary-color" value="#0B1531">
                              <label for="secondary-color" class="form-label">Secondary
                                Color</label>
                            </div>
                          </div>
                          <div class="col-md-4">
                            <div class="form-group d-flex align-items-center gap-2">
                              <input type="color" class="form-control form-control-color"
                              id="tertiary-color" name="tertiary-color" value="#001846">
                              <label for="tertiary-color" class="form-label">Tertiary Color</label>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>

                    <!-- Typography -->
                    <div class="col-md-6">
                      <div class="from-group">
                        <label class="form-label" for="theme">Typography </label>
                        <select class="form-select" name="typography">
                          <option value="default" selected>Default</option>
                          <option value="sans-serif">Sans-Serif</option>
                          <option value="serif">Serif</option>
                          <option value="monospace">Monospace</option>
                        </select>
                      </div>
                    </div>

                    <div class="mt-4 text-lg-end">
                      <button type="reset" class="btn btn-danger me-2">Reset</button>
                      <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                  </div>
            </form>
            </div>
        </div>
        </div>
    </div>
    </div>
</div>