<?php

$cryption_panel_classes = array('panel', 'row');
$cryption_center_classes = 'panel-center col-xs-12';

get_header(); ?>

<div id="main-content" class="main-content">

<?php echo cryption_page_title(); ?>

	<div class="block-content">
		<div class="container">
			<div class="<?php echo esc_attr(implode(' ', $cryption_panel_classes)); ?>">
				<div class="<?php echo esc_attr($cryption_center_classes); ?>">
				
				<h4 class="asiic-info">Общая информация</h4>
				<div class="item"><b class="item-name">Номер асика:</b>
				<?php if ( get_field('asic-searial') ) { ?>
					<?php the_field('asic-searial'); ?>
				<?php } ?>
				</div>
				<div class="item"><b class="item-name">Статус асика:</b>
				<?php if ( get_field('asic-status') ) { ?>
					<?php the_field('asic-status'); ?>
				<?php } ?>
				</div>
				<div class="item"><b class="item-name">Локация:</b>
				<span class="loc"><?php if ( get_field('asic-location') ) { ?>
					<?php the_field('asic-location'); ?>
				<?php } ?></span>
				</div>
				<div class="item"><b class="item-name">IP Адрес:</b>
				<?php if ( get_field('asic-ip') ) { ?>
					<?php the_field('asic-ip'); ?>
				<?php } ?> 
				</div>
				<div class="item"><b class="item-name">Poll:</b>
				<?php if ( get_field('asic-poll') ) { ?>
					<?php the_field('asic-poll'); ?>
				<?php } ?> 
				</div>
				<div class="item"><b class="item-name">Владелец асика:</b>
				<?php if ( get_field('asic-owner') ) { ?>
					<?php the_field('asic-owner'); ?>
				<?php } ?> 
				</div>
				<div class="item"><b class="item-name">Страна владельца:</b>
				<?php if ( get_field('asic-owner-country') ) { ?>
					<?php the_field('asic-owner-country'); ?>
				<?php } ?> 
				</div>
				<div class="item"><b class="item-name">Дата установки:</b>
				<?php if ( get_field('asic-install-date') ) { ?>
					<?php the_field('asic-install-date'); ?>
				<?php } ?> 
				</div>
				
				<h4 class="asiic-info">Информация об Асике</h4>
				<div class="item"><b class="item-name">Модель асика:</b>
				<?php if ( get_field('asic_mode') ) { ?>
					<?php the_field('asic_mode'); ?>
				<?php } ?> 
				</div>
				<div class="item"><b class="item-name">Версия асика:</b>
				<?php if ( get_field('Asic_VERSION') ) { ?>
					<?php the_field('Asic_VERSION'); ?>
				<?php } ?> 
				</div>
				<h4 class="asiic-info">Информация о блоке питания</h4>
				<div class="item"><b class="item-name">Модель БП:</b>
				<?php if ( get_field('Power_Supply_MODEL') ) { ?>
					<?php the_field('Power_Supply_MODEL'); ?>
				<?php } ?>
				</div>
				<div class="item"><b class="item-name">Номер БП:</b>
				<?php if ( get_field('power_supply-NO') ) { ?>
					<?php the_field('power_supply-NO'); ?>
				<?php } ?>
				</div>
				<div class="item"><b class="item-name">Серийный номер БП:</b>
				<?php if ( get_field('power_supply-SN') ) { ?>
					<?php the_field('power_supply-SN'); ?>
				<?php } ?>
				</div>
				<h4 class="asiic-info">Информация о модуле интернет</h4>
				<div class="item"><b class="item-name">Модель МИ:</b>
				<?php if ( get_field('сontrol_unit-MODEL') ) { ?>
					<?php the_field('сontrol_unit-MODEL'); ?>
				<?php } ?>
				</div>
				<div class="item"><b class="item-name">Серийный номер МИ:</b>
				<?php if ( get_field('сontrol_unit_sn') ) { ?>
					<?php the_field('сontrol_unit_sn'); ?>
				<?php } ?>
				</div>
				<div class="item"><b class="item-name">Номер заказа МИ:</b>
				<?php if ( get_field('сontrol_unit_wo') ) { ?>
					<?php the_field('сontrol_unit_wo'); ?>
				<?php } ?>
				</div>
				
				
				
				</div>
			</div>
		</div><!-- .container -->
	</div><!-- .block-content -->
</div><!-- #main-content -->

<?php
get_footer();
