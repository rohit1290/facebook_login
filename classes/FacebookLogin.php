<?php
use Elgg\DefaultPluginBootstrap;

class FacebookLogin extends DefaultPluginBootstrap {

  public function init() {
  	// sign on with facebook
  	if (facebook_login_allow_sign_on_with_facebook()) {
  		elgg_extend_view('core/account/login_box', 'facebook_login/login_btn');
  		elgg_extend_view('login/sidebar/login', 'facebook_login/login_btn');
  	}
  }
}