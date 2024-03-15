<div class="row">
    <div class="row col-md-12">
         <?php
             $ls = $this->uri->uri_string();
             $base = 'admin/permissions/';
         ?>
        <div class="middle">

            <div class="informer">
                <a href="<?php echo base_url($base . 'assign'); ?>" class="<?php echo preg_match('/^(admin\/permissions\/assign)$/i', $ls) ? 'acc' : ''; ?>">
                    <span class="icomg-share3"></span>
                    <span class="text">Assign Modules</span>
                </a>
            </div>

            <div class="informer">
                <a href="<?php echo base_url($base . 'view'); ?>" class="<?php echo preg_match('/^(admin\/permissions\/view)$/i', $ls) ? 'acc' : ''; ?>">
                    <span class="icomg-contract"></span>
                    <span class="text">Assign Permissions</span>
                </a>
            </div>

            <div class="informer">
                <a href="<?php echo base_url($base . 'fix_resources'); ?>" class="<?php echo preg_match('/^(admin\/permissions\/fix_resources)$/i', $ls) ? 'acc' : ''; ?>">
                    <span class="icomg-link2"></span>
                    <span class="text">Configure Modules</span>
                </a>
            </div>

            <div class="informer">
                <a href="<?php echo base_url($base . 'fix_routes'); ?>" class="<?php echo preg_match('/^(admin\/permissions\/fix_routes)$/i', $ls) ? 'acc' : ''; ?>">
                    <span class="icomg-cog"></span>
                    <span class="text">Configure Routes</span>
                </a>
            </div>

            <div class="informer">
                <a href="<?php echo base_url($base . 'generate_routes'); ?>" class="<?php echo preg_match('/^(admin\/permissions\/generate_routes)$/i', $ls) ? 'acc' : ''; ?>">
                    <span class="icomg-refresh"></span>
                    <span class="text">Update Routes</span>
                </a>
            </div>

            <div class="informer">
                <a href="<?php echo base_url($base . 'generate_resources'); ?>" class="<?php echo preg_match('/^(admin\/permissions\/generate_resources)$/i', $ls) ? 'acc' : ''; ?>">
                    <span class="icomg-refresh"></span>
                    <span class="text">Update Modules</span>
                </a>
            </div>

        </div>
    </div> 

</div>
<style> 
    .middle .informer > a.acc {
         border: 1px solid #DDD;
         padding: 10px;
         display: block;
         float: left;
         text-align: center;
         text-decoration: none;
         background: #E5E5E5;
         background: -moz-linear-gradient(top, #F9F9F9 0%, #E5E5E5 100%);
         background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#54a1e6), color-stop(100%,#E5E5E5));
         background: -o-linear-gradient(top, #F9F9F9 0%,#E5E5E5 100%);
         background: -ms-linear-gradient(top, #F9F9F9 0%,#E5E5E5 100%);
         background: linear-gradient(top, #F9F9F9 0%,#E5E5E5 100%);
         filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#F9F9F9', endColorstr='#E5E5E5',GradientType=0 );
         -moz-border-radius: 4px;
         -webkit-border-radius: 4px;
         border-radius: 4px;
    }
</style>