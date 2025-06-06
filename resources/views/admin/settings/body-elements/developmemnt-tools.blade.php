<div class="tab-pane fade" id="v-pills-developmemnt_tools" role="tabpanel" aria-labelledby="v-pills-developmemnt_tools-tab">
    <div class="row g-4">
        <div class="col-12">
            <div class="trk-card shadow">
                    <div class="trk-card__wrapper">
                        <div class="trk-card__header text-center">
                            <h5>{{ __('default.dev_tools') }}</h5>
                        </div>
                        <div class="trk-card__body">
                            <div class="mb-3">
                                <a href="{{url('dev/logs')}}" target="_blank" class="btn btn-primary mt-2">View Log</a>
                                <a href="{{url('dev/db')}}" target="_blank" class="btn btn-primary mt-2">View DB</a>
                                <a href="{{url('dev/env')}}" target="_blank" class="btn btn-primary mt-2">View Env</a>
                                <a href="{{url('admin/health')}}" target="_blank" class="btn btn-primary mt-2">View Health</a>
                            </div>
                        </div>
                    </div>

                    <br>

                    <div class="trk-card__wrapper">
                        <div class="trk-card__header text-center">
                            <h5>Artisan Command</h5>
                        </div>
                        <div class="trk-card__body">

                            <div class="mb-4">
                                <a href="{{route('admin.artisan.storage.link')}}" class="btn btn-primary mt-2">Storage Link</a>
                                <a href="{{route('admin.artisan.optimize.clear')}}" class="btn btn-primary mt-2">Optimize Clear</a>
                                <a href="{{route('admin.artisan.migrate.seed')}}" class="btn btn-danger mt-2">Migrate:fresh & Seed</a>
                            </div>
                            <div class="mb-4">
                                <a href="{{route('admin.artisan.backup.run')}}" class="btn btn-primary mt-2">Backup Run</a>
                                <a href="{{route('admin.artisan.backup.clean')}}" class="btn btn-primary mt-2">Backup Clean</a>
                                <a href="{{route('admin.artisan.backup.list')}}" class="btn btn-primary mt-2">Backup List</a>
                                <a href="{{route('admin.artisan.backup.monitor')}}" class="btn btn-primary mt-2">Backup Monitor</a>
                            </div>
                            <div class="mb-4">
                                <a href="{{route('admin.artisan.health.check')}}" class="btn btn-primary mt-2">Check Health</a>
                            </div>



                            <form class="form" action="{{ route('admin.artisan.submit') }}" method="post" enctype="multipart/form-data">
                                @csrf
    
                                <div class="row g-4">

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="form-label" for="migrate_filename">Migrate Migration File</label>
                                            <input type="text" class="form-control" placeholder="Exp: only_filename.php" name="migrate_filename" />
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-10">
                                            <button type="submit" class="btn btn-primary mt-4">Run</button>
                                        </div>
                                    </div>

                                </div>
    
                            </form>

                            <br>

                            <form class="form" action="{{ route('admin.artisan.submit') }}" method="post" enctype="multipart/form-data">
                                @csrf
    
                                <div class="row g-4">

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="form-label" for="seeder_tablename">Generate Seeder</label>
                                            <input type="text" class="form-control" placeholder="Exp: users" name="seeder_tablename" />
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-10">
                                            <button type="submit" class="btn btn-primary mt-4">Run</button>
                                        </div>
                                    </div>

                                </div>
    
                            </form>

                            <br>

                            <form class="form" action="{{ route('admin.artisan.submit') }}" method="post" enctype="multipart/form-data">
                                @csrf
    
                                <div class="row g-4">

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="form-label" for="seed_classname">Seed Class</label>
                                            <input type="text" class="form-control" placeholder="Exp: ClassName" name="seed_classname" />
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-10">
                                            <button type="submit" class="btn btn-primary mt-4">Run</button>
                                        </div>
                                    </div>

                                </div>
    
                            </form>
                        </div>
                    </div>
                    <br>

                    <div class="trk-card__wrapper">
                        <div class="trk-card__header text-center">
                            <h5>API</h5>
                        </div>
                        <div class="trk-card__body">

                            <div class="mb-4">
                                <a href="{{url('/api/documentation')}}" target="_blank" class="btn btn-primary mt-2">View Api Docs</a>
                                <a href="{{route('admin.swagger.sync')}}" class="btn btn-danger mt-2">Sync Latest Docs</a>
                            </div>
                        </div>
                    </div>
            </div>
        </div>
    </div>
</div>
