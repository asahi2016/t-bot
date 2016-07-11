<div id="container">
	<div class="block form-group">
		<div style="text-align:center;padding:5px;margin-top: 50px;">
			<p>
			<!--<a href="http://www.twitterbots.dev"><img src="https://i.imgur.com/zEnLrRJ.png"></a>-->
			<h1>Twitter Bots</h1>
			</p>
			<!--<p>
				<small>
					Written by <a target="_blank" href="https://twitter.com/krishna2705">@Asahitechnologies</a>.
				</small>
			</p>-->
		</div>
	</div>

	<div id="body">
		<p>
			We've provide twitter bots services. If you want to make twitter bots to your business tweets like promotion,
			</br> Please here you can sign in by using following social network.
			 <!--If you have previously authenticated, Please proceed with <a href="<?/* echo  base_url();*/?>login"> Login</a>-->
		</p>
		<p> <span> Select a service to authenticate with.</span></p>
		<ul id="provider-list">
		<?php
			// Output the enabled services and change link/button if the user is authenticated.
			$this->load->helper('url');
			foreach($providers as $provider => $data) {
				if ($data['connected']) {
					echo "<li>".anchor('web/logout/'.$provider,'Logout of '.$provider, array('class' => 'connected'))."</li>";
				} else {
					echo "<li>".anchor('web/login/'.$provider,$provider, array('class' => 'login'))."</li>";
				}
			}
		?>
		</ul>
		<br style="clear: both;"/>

	</div>
</div>
