<?php

/**
 * Class for Pagetitle Html element
 * @todo $discussionurl,  $faqurl;
 */
class Admin_Theme_Element_Pagetitle extends Admin_Theme_Menu_Element
{

	protected $option = array(
		'type' => Admin_Theme_Menu_Element::TYPE_PAGETITLE,
	);

	public function render()
	{
		ob_start();
		?>
		<a name="ml_top" id="ml_top"></a>
		<div class="admin_top">
			<h2><?php echo $this->name; ?></h2>
			<?php if($_GET['page'] != SHORTNAME.'_dummy'): ?>
				<input name="save_options" type="submit" value="Save Changes" class="ml_save top"  />
			<?php endif; ?>
			<div class="clear"></div>
		</div>
<!--		<div class="color_separator clear">
			<div class="color_1"></div>
			<div class="color_2"></div>
			<div class="color_3"></div>
			<div class="color_4"></div>
			<div class="color_5"></div>
		</div>-->
		<div class="ml_admin_wrap">
			<ul>
				<?php
				$html = ob_get_clean();
				return $html;
			}

		}
		?>