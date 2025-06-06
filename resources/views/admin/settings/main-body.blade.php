<div class="col-xxl-9 col-lg-8 col-md-7">
    <div class="admin__details">
        <div class="tab-content" id="v-pills-tabContent">

            @include('admin.settings.body-elements.general-settings')

            @include('admin.settings.body-elements.theme-settings')

            @include('admin.settings.body-elements.company-info')

            @include('admin.settings.body-elements.email-settings')
            
            
            @include('admin.settings.body-elements.policy-settings')
            
            @if(env('APP_DEBUG'))
            @include('admin.settings.body-elements.developmemnt-tools')
            @endif


            <div id="tab-content"></div>

        </div>
    </div>
</div>