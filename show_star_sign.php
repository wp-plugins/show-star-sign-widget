<?php

/*
  Plugin Name: Show Star Sign Widget
  Plugin URI: http://dianagarland.com/wp-show-star-sign-widget/
  Description: Sidebar widget which displays a star sign; yours, the visitor's, or the current one.
  Author: Duncan Marshall
  Version: 1.0.0
  Author URI: http://duncanmarshall.net/

 * *************************************************************************

  Copyright (C) 2010-2013 Duncan Marshall

  This program is free software: you can redistribute it and/or modify
  it under the terms of the GNU General Public License as published by
  the Free Software Foundation, either version 3 of the License, or
  (at your option) any later version.

  This program is distributed in the hope that it will be useful,
  but WITHOUT ANY WARRANTY; without even the implied warranty of
  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
  GNU General Public License for more details.

  You should have received a copy of the GNU General Public License
  along with this program.  If not, see <http://www.gnu.org/licenses/>.

 * **************************************************************************/


class Show_Star_Sign_Widget extends WP_Widget {

	public function __construct() {
		parent::__construct(
	 		'Show_Star_Sign_Widget',
			'Show Star Sign Widget',
			array( 'description' => __( "Displays a star sign; yours, the visitor's, or the current one.", 'text_domain' ),)
		);
	}

	public function widget( $args, $instance ) {
	
		extract( $args );
		$title = apply_filters( 'widget_title', $instance['title'] );

		echo $before_widget;
		if ( ! empty( $title ) )
			echo $before_title . $title . $after_title;
		
		$this->DoWebEmbedWidget(array("fcolor" => $instance['fcolor'], "ns" => $instance['ns'], "mode" => $instance['display_mode'], "links_enabled" => $instance['links_enabled'], "user_sign" => $instance['user_sign']));

		echo $after_widget;
	}

	public function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['fcolor'] = strip_tags($new_instance['fcolor']);
		$instance['display_mode'] = strip_tags($new_instance['display_mode']);
		$instance['ns'] = strip_tags($new_instance['ns']);
		$instance['links_enabled'] = $new_instance['links_enabled'];
		$instance['user_sign'] = strip_tags($new_instance['user_sign']);
		
		return $instance;
	}

	public function form( $instance ) {
	
		$links_enabled = esc_attr( $instance[ 'links_enabled' ] );
		$title = esc_attr( $instance[ 'title' ] );
		if ($title == ""){$title = "Star sign:";}
		$fcolor = esc_attr( $instance[ 'fcolor' ]);
		if ($fcolor == ""){$fcolor = "000000";}
		$display_mode = esc_attr( $instance[ 'display_mode' ]);
		if ($display_mode == ""){$display_mode = "showcurrentsign";}
		$ns = esc_attr( $instance[ 'ns' ] );
		if ($ns == ""){$ns = "SSSW_";}
		$user_sign = esc_attr( $instance[ 'user_sign' ] );			
		if ($user_sign == ""){$user_sign = "doesntmatter";}

		?>
		
		<p>
		<label for="<?php echo $this->get_field_id('links_enabled'); ?>"><?php _e('Allow outside links:'); ?></label> 
		<input id="<?php echo $this->get_field_id('links_enabled'); ?>" name="<?php echo $this->get_field_name('links_enabled'); ?>" type="checkbox" value="on" <?php if ($links_enabled=="on") {echo ' checked="yes"'; } ?>>
		</input>
		</p>	

		<?php if ($links_enabled != "on"){ ?>
		
			<span style="color:red;">Outside links need to be enabled for the plugin to work properly.  If they're not, the widget renders nothing.</span>
		
		<?php } ?>
		
		
		<p>
		<label for="<?php echo $this->get_field_id('display_mode'); ?>"><?php _e('Display Mode:'); ?></label>
		<select name="<?php echo $this->get_field_name( 'display_mode' ); ?>" id="<?php echo $this->get_field_id('display_mode'); ?>" class="widefat">

			<option <?php $this->DoOption("showcurrentsign", $display_mode); ?>>Current Sign</option>
			<option <?php $this->DoOption("showmysign", $display_mode); ?>>My Sign</option>
			<option <?php $this->DoOption("signpicker", $display_mode); ?>>Calculator</option>
		
		</select>
		</p>
		
		
		<p>
		<label for="<?php echo $this->get_field_id('fcolor'); ?>"><?php _e('Display color:'); ?></label>
		<select name="<?php echo $this->get_field_name( 'fcolor' ); ?>" id="<?php echo $this->get_field_id('fcolor'); ?>" class="widefat">

			<option <?php $this->DoOption("ffffff", $fcolor); ?> style="background-color:#ffffff;">White</option>
			<option <?php $this->DoOption("000000", $fcolor); ?> style="background-color:#000000;color:white;">Black</option>
			<option <?php $this->DoOption("ff0000", $fcolor); ?> style="background-color:#ff0000;">Red</option>
			<option <?php $this->DoOption("ffff00", $fcolor); ?> style="background-color:#ffff00;">Yellow</option>
			<option <?php $this->DoOption("00ff00", $fcolor); ?> style="background-color:#00ff00;">Green</option>
			<option <?php $this->DoOption("0000ff", $fcolor); ?> style="background-color:#0000ff;">Blue</option>
		
		</select>
		</p>

		<p>
  		<label for="<?php echo $this->get_field_id('user_sign'); ?>"><?php _e('Your star sign:'); ?></label>	
		[<a style="cursor:pointer" title="If you don't fill one in, the widget displays the current star sign instead.">?</a>]:	
		<select name="<?php echo $this->get_field_name( 'user_sign' ); ?>" id="<?php echo $this->get_field_id('user_sign'); ?>" class="widefat">

			<option <?php $this->DoOption("doesntmatter", $user_sign); ?>>Doesn't matter...</option>
			<option <?php $this->DoOption("aries", $user_sign); ?>>Aries (born 21st of March to the 19th of April)</option>
			<option <?php $this->DoOption("taurus", $user_sign); ?>>Taurus (born 20th of April to the 20th of May)</option>
			<option <?php $this->DoOption("gemini", $user_sign); ?>>Gemini (born 21st of May to the 21st of June)</option>
			<option <?php $this->DoOption("cancer", $user_sign); ?>>Cancer (born 22nd of June to the 22nd of July)</option>
			<option <?php $this->DoOption("leo", $user_sign); ?>>Leo (born 23rd of July to the 22nd of August)</option>
			<option <?php $this->DoOption("virgo", $user_sign); ?>>Virgo (born 23rd of August to the 22nd of September)</option>
			<option <?php $this->DoOption("libra", $user_sign); ?>>Libra (born 23rd of September to the 22nd of October)</option>
			<option <?php $this->DoOption("scorpio", $user_sign); ?>>Scorpio (born 23rd of October to the 22nd of November)</option>
			<option <?php $this->DoOption("sagittarius", $user_sign); ?>>Sagittarius (born 22nd of November - 21st of December)</option>
			<option <?php $this->DoOption("capricorn", $user_sign); ?>>Capricorn (born  22nd of December to the 21st of January)</option>
			<option <?php $this->DoOption("aquarius", $user_sign); ?>>Aquarius (born 20th of January to the 19th of February)</option>
			<option <?php $this->DoOption("pisces", $user_sign); ?>>Pisces (born  the 20th February to the 20th of March)</option>

		
		</select>
		</p>
		

		

		<p>
		<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title'); ?></label>
		[<a style="cursor:pointer" title="Will be displayed as the widget title.">?</a>]:
		<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
		</p>

		<p>
		<label for="<?php echo $this->get_field_id('ns'); ?>"><?php _e('Namespace'); ?></label> 
		[<a style="cursor:pointer" title="The scripts and styles for this widget are namespaced to avoid conflicts.  You're probably fine with the default setting.">?</a>]:
		<input class="widefat" id="<?php echo $this->get_field_id('ns'); ?>" name="<?php echo $this->get_field_name('ns'); ?>" type="text" value="<?php echo $ns; ?>" />
		</p>					



		<?php 

		
	}
	
	private function DoOption($Value, $Selected){

		$Out = "";

		if ($Selected == $Value){$Out = 'selected="selected" ';}

		echo $Out.'value="'.$Value.'" ';

	}
		
	private	function DoWebEmbedWidget($Args) {
	

	
		if ($Args['links_enabled'] != "on"){return;} 
		
		$CurrentSign = "";
		
		$NS = 'SSSW_';//todo
		$FColor = "00FF00";
		$Mode = "showpicker";

		if ($Args['ns'] != null){$NS = $Args['ns'];}
		if ($Args['fcolor'] != null){$FColor = $Args['fcolor'];}
		if ($Args['mode'] != null){$Mode = $Args['mode'];}

		switch ( date( "n" ) ){

		  case 1 :
		  
			if (date( "d" ) <= 20) {$CurrentSign = "capricorn";}else{$CurrentSign = "aquarius";}
			break;

		  case 2 :

			if (date( "d" ) <= 19) {$CurrentSign = "aquarius";}else{$CurrentSign = "pisces";}
			break;

		  case 3 :
	  
			if (date( "d" ) <= 20) {$CurrentSign = "pisces";}else{$CurrentSign = "aries";}
			break;

		  case 4 :
	  
			if (date( "d" ) <= 20) {$CurrentSign = "aries";}else{$CurrentSign = "taurus";}		  
			break;

		  case 5 :
		  
			if (date( "d" ) <= 21) {$CurrentSign = "taurus";}else{$CurrentSign = "gemini";}		  
			break;

		  case 6 :
	  
			if (date( "d" ) <= 21) {$CurrentSign = "gemini";}else{$CurrentSign = "cancer";}		  
			break;

		  case 7 :
	  
			if (date( "d" ) <= 23) {$CurrentSign = "cancer";}else{$CurrentSign = "leo";}		  
			break;

		  case 8 :
		  
			if (date( "d" ) <= 23) {$CurrentSign = "leo";}else{$CurrentSign = "virgo";}		  
			break;

		  case 9 :
		  
			if (date( "d" ) <= 23) {$CurrentSign = "virgo";}else{$CurrentSign = "libra";}		  
			break;

		  case 10 :
	  
			if (date( "d" ) <= 23) {$CurrentSign = "libra";}else{$CurrentSign = "scorpio";}		  
			break;

		  case 11 :
	  
			if (date( "d" ) <= 22) {$CurrentSign = "scorpio";}else{$CurrentSign = "sagittarius";}
			break;

		  case 12 :
	  
			if (date( "d" ) <= 22) {$CurrentSign = "sagittarius";}else{$CurrentSign = "capricorn";}
			break;
		}
		
		$TheSign = $CurrentSign;
		$CurrentSignName = $CurrentSign;
		$CurrentSign = plugins_url()."/show-star-sign-widget/images/".$FColor."/".$CurrentSign.".png";
		
		$SignImage = $CurrentSign;
		$TypeImage = plugins_url()."/show-star-sign-widget/images/".$FColor."/showcurrentsign.png";

		
		if ($Mode == "showmysign"){
		
			$MySign = $Args['user_sign'];
		
			if ($MySign != "doesntmatter"){
		
				$TypeImage = plugins_url()."/show-star-sign-widget/images/".$FColor."/".$Mode.".png";
				$SignImage = plugins_url()."/show-star-sign-widget/images/".$FColor."/".$MySign.".png";
				$TheSign = $MySign;
			
			} else {
			
				$Mode = "showcurrentsign";
			
			}
			
		}



		?>

		<div id="<?php echo $NS; ?>PlanetCalcForm"  style="<?php if ($Mode != "signpicker") { ?>display:none;<?php } ?>">
		
			<p>When is your birthday?</p>
		
			<p>
				
				<select id="<?php echo $NS; ?>DOB">
					
					<option value="aries">21 Mar - 19 Apr</option>
					<option value="taurus">20 Apr - 20 May</option>
					<option value="gemini">21 May - 21 Jun</option>
					<option value="cancer">22 Jun - 22 Jul</option>
					<option value="leo"> 23 Jul - 22 Aug</option>
					<option value="virgo">23 Aug - 22 Sep</option>
					<option value="libra">23 Sep - 22 Oct</option>
					<option value="scorpio">23 Oct - 22 Nov</option>
					<option value="sagittarius">22 Nov - 21 Dec</option>
					<option value="capricorn">22nd Dec - 21 Jan</option>
					<option value="aquarius">20 Jan - 19 Feb</option>
					<option value="pisces">20 Feb - 20 Mar</option>
				
				</select>
				
			</p>
			
			<p><button onclick="<?php echo $NS; ?>.SubmitButton();" />Submit</button></p>
		
		</div>

		<div id="<?php echo $NS; ?>Display" style="<?php if ($Mode == "signpicker") { ?>display:none;<?php } ?>">
			
			<p style="margin:0px;padding:0px;text-align:center;"><img id="<?php echo $NS; ?>TypeImg" src="<?php echo $TypeImage; ?>" style="border:0px;padding:0px;margin:0px;box-shadow:#000000 0px 0px 0px 0px;" /></p>
			<p style="margin:0px;padding:0px;text-align:center;"><img id="<?php echo $NS; ?>SignImg" src="<?php echo $SignImage; ?>" style="border:0px;padding:0px;margin:0px;box-shadow:#000000 0px 0px 0px 0px;" /><p>

		</div>
		
		<p style="text-align:center;">
			
			<?php if ($Mode != "signpicker"){ ?>
			
				<a target="_blank" id="<?php echo $NS; ?>Abouter" href="http://dianagarland.com/about-<?php echo $TheSign; ?>" >About Sign</a> - 
				<a target="_blank" id="<?php echo $NS; ?>Switcher" href="http://dianagarland.com/whats-my-sign">Whats yours?</a>
				
			<?php } else { ?>
			
				<a target="_blank" id="<?php echo $NS; ?>Abouter" href="http://dianagarland.com/sun-signs/">About Signs</a> - 
				<a target="_blank" id="<?php echo $NS; ?>Switcher" href="#">Current Sign</a>
			
			<?php } ?>
			


		</p>

		<script type="text/javascript" language="javascript">

			var <?php echo $NS; ?> = new function <?php echo $NS; ?>Dec(){
				
				var Switcher;
				var CalcForm; 
				var Display;
				var TypeImg;
				var SignImg;
				var DatePicker;
				var Abouter;
				
				this.StartUp = function StartUp(){

					this.Switcher = document.getElementById("<?php echo $NS; ?>Switcher");
					this.Abouter = document.getElementById("<?php echo $NS; ?>Abouter");
					this.CalcForm = document.getElementById("<?php echo $NS; ?>PlanetCalcForm");
					this.Display = document.getElementById("<?php echo $NS; ?>Display");
					this.TypeImg = document.getElementById("<?php echo $NS; ?>TypeImg");
					this.SignImg = document.getElementById("<?php echo $NS; ?>SignImg");
					this.DatePicker = document.getElementById("<?php echo $NS; ?>DOB");
					
					var This = this;
					
					this.Switcher.onclick = function (){
					
						<?php if ($Mode != "signpicker"){ ?>
				
							This.SwitchToCalc();
							
						<?php } else { ?>
						
							This.SwitchToCurrent();
			
						<?php } ?>
					
						return false;					
					
					}
					
				}

				this.SwitchToCalc = function SwitchToCalc(){ 

					this.Switcher.innerHTML = "Current Sign";
					
					var This = this;
					
					this.Switcher.onclick = function (){
					
						This.SwitchToCurrent();
						return false;
					
					}
					
					this.CalcForm.style.display = "";
					this.Display.style.display = "none";

					
				}
				
				this.SwitchToCurrent = function SwitchToCurrent(){
				
					this.Switcher.innerHTML = "What's Yours?";
					
					var This = this;
					
					 this.Switcher.onclick = function (){
					
						This.SwitchToCalc();
						return false;
					
					} 

					this.CalcForm.style.display = "none";
					this.Display.style.display = "";
					this.SignImg.src = "<?Php echo $CurrentSign; ?>";
					this.TypeImg.src = "<?php echo plugins_url(); ?>/show-star-sign-widget/images/" + "<?php echo $FColor; ?>" + "/showcurrentsign.png";
					
					this.Abouter.innerHTML = "About Sign";
					this.Abouter.href = "http://dianagarland.com/about-<?php echo $CurrentSignName; ?>";
					
				}
				
				this.SubmitButton = function SubmitButton(){
				
					this.CalcForm.style.display = "none";
					this.Display.style.display = "";
					
					this.SignImg.src = "<?php echo plugins_url(); ?>/show-star-sign-widget/images/" + "<?php echo $FColor; ?>" + "/" + this.DatePicker.value + ".png";
					this.TypeImg.src = "<?php echo plugins_url(); ?>/show-star-sign-widget/images/" + "<?php echo $FColor; ?>" + "/yoursignis.png";
					
					this.Abouter.innerHTML = "About Sign";
					this.Abouter.href = "http://dianagarland.com/about-" + this.DatePicker.value;
					
					
				}
				
			}

			<?php echo $NS ?>.StartUp();

		</script>

		<?php

	
		
	}

} // class Daily_Horoscope_Widget


add_action( 'widgets_init', create_function( '', 'register_widget("Show_Star_Sign_Widget");' ) );




?>