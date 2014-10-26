      <div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <div class="container">
          <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".navbar-collapse">
              <span class="sr-only">Toggle navigation</span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand font-heading" href="<?php echo base_url(); ?>">Sint-Joris</a>
          </div>
          <div class="collapse navbar-collapse">
            <ul class="nav navbar-nav">
              <li <?php if($Active == 1): ?> class="active" <?php endif; ?>> 
								<a href="<?php echo base_url(); ?>backend"> <span class="fa fa-leaf Icon-color"></span> Takken </a> 
							</li>
							
              <?php if($Role == 1): ?>
                <li <?php if($Active == 2): ?> class="active" <?php endif; ?>> 
								  <a href="<?php echo base_url(); ?>verhuur/admin_verhuur"> <span class="fa fa-home Icon-color"></span> Verhuur </a> 
							 </li>
              <?php endif; ?>
							
              <li <?php if($Active == 5): ?> class="active" <?php endif; ?>> 
								<a href=""><span class="fa fa-info-circle Icon-color"></span> Info </a> 
							</li>
							
              <li class="<?php if($Active == 1): ?> active <?php endif; ?> dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown" href="<?php echo base_url(); ?>Takken">
                  <span class="fa fa-asterisk Icon-color"></span> Media
                </a>

                <ul class="dropdown-menu" role="menu">
									<li><a href="<?php echo base_url(); ?>Upload_files"><span class="fa fa-file-text-o"></span> T groentje</a></li>
		              <li><a href="<?php echo base_url(); ?>Fotos/Index_admin"><span class="fa fa-camera-retro"></span> Foto's</a></li>
                </ul>
              </li>
              
              <li>
                <a href="<?php echo base_url(); ?>Inschrijvingen/Admin_ontbijt">
                  <span class="fa fa-asterisk Icon-color"></span> Inschrijvingen
                </a>
              </li>
            </ul>

            <ul class="nav navbar-nav navbar-right">
              <?php if($Role == 1): ?>
                <li <?php if($Active == 6): ?> class="active "<?php endif; ?>>
									<a href="<?php echo base_url(); ?>leiding/"><span class="octicon octicon-organization Icon-color"></span></a>
								</li>
              <?php endif; ?>
							
							<li>
								<a href="<?php echo base_url(); ?>Leiding/settings/<?php echo $User ?>">
									<span class="octicon octicon-gear Icon-color"></span>
								</a>
							</li>

              <li>
								<a href="<?php echo base_url(); ?>backend/Logout"><span class="octicon octicon-sign-out Icon-color"></span></a>
							</li>
            </ul>
          </div>
        </div>
      </div>