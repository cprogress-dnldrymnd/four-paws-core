<div class="eltdf-testimonials-holder eltdf-testimonials-slider clearfix <?php echo esc_attr($holder_classes); ?>">
	<div class="eltdf-testimonials eltdf-custom-testimonials-slider-holder" <?php echo academist_elated_get_inline_attrs($data_attr) ?>>

		<?php if ($query_results->have_posts()) :
			$sliderIndex = 0;
		?>
			<div class="eltdf-custom-testimonials-slider">

				<?php
				while ($query_results->have_posts()) : $query_results->the_post();
					$title    = get_post_meta(get_the_ID(), 'eltdf_testimonial_title', true);
					$text     = get_post_meta(get_the_ID(), 'eltdf_testimonial_text', true);
					$author   = get_post_meta(get_the_ID(), 'eltdf_testimonial_author', true);
					$position = get_post_meta(get_the_ID(), 'eltdf_testimonial_author_position', true);
					$current_id = get_the_ID();
				?>

					<div class="eltdf-slider-item eltdf-slider-item-<?php echo academist_elated_get_module_part($sliderIndex++);
																	if ($sliderIndex == 1) echo " eltdf-animate-left"; ?>">
						<div class="eltdf-testimonial-content" id="eltdf-testimonials-<?php echo esc_attr($current_id) ?>" <?php academist_elated_inline_style($box_styles); ?>>

							<div class="eltdf-testimonial-image-holder">
								<?php if (has_post_thumbnail()) { ?>
									<div class="eltdf-testimonial-image">
										<?php echo get_the_post_thumbnail(get_the_ID()); ?>
									</div>
								<?php } ?>
							</div>

							<div class="eltdf-testimonial-text-holder clearfix">
								<?php if (!empty($title)) { ?>
									<h3 itemprop="name" class="eltdf-testimonial-title entry-title"><?php echo esc_html($title); ?></h3>
								<?php } ?>
								<?php if (!empty($text)) { ?>
									<p class="eltdf-testimonial-text"><?php echo esc_html($text); ?></p>
								<?php } ?>
								<?php if (!empty($author)) { ?>
									<h4 class="eltdf-testimonial-author">
										<span class="eltdf-testimonials-author-name"><?php echo esc_html($author . ', '); ?></span>
										<?php if (!empty($position)) { ?>
											<span class="eltdf-testimonials-author-job"><?php echo esc_html($position); ?></span>
										<?php } ?>
									</h4>
								<?php } ?>
							</div>
						</div>
					</div>

				<?php
				endwhile;
				?>
			</div>
			<div class="eltdf-testimonials-slider-nav">
				<button type="button" class="eltdf-btn-ts-prev">
					<svg xmlns="http://www.w3.org/2000/svg" width="43.985" height="43.985" viewBox="0 0 43.985 43.985">
						<g id="left" transform="translate(45.985 45.985) rotate(180)">
							<path id="Path_106" data-name="Path 106" d="M11,22.995l6.335-6.335h0a.937.937,0,0,0,0-1.326h0L11,9" transform="translate(10.66 7.995)" fill="none" stroke="#323232" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
							<path id="Path_107" data-name="Path 107" d="M3,23.992C3,6.705,6.705,3,23.992,3S44.985,6.705,44.985,23.992,41.279,44.985,23.992,44.985,3,41.279,3,23.992Z" transform="translate(0 0)" fill="none" stroke="#323232" stroke-width="2" />
						</g>
					</svg>

				</button>
				<button type="button" class="eltdf-btn-ts-next">
					<svg xmlns="http://www.w3.org/2000/svg" width="43.985" height="43.985" viewBox="0 0 43.985 43.985">
						<g id="right" transform="translate(-2 -2)">
							<path id="Path_106" data-name="Path 106" d="M11,22.995l6.335-6.335h0a.937.937,0,0,0,0-1.326h0L11,9" transform="translate(10.66 7.995)" fill="none" stroke="#323232" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
							<path id="Path_107" data-name="Path 107" d="M3,23.992C3,6.705,6.705,3,23.992,3S44.985,6.705,44.985,23.992,41.279,44.985,23.992,44.985,3,41.279,3,23.992Z" transform="translate(0 0)" fill="none" stroke="#323232" stroke-width="2" />
						</g>
					</svg>

				</button>
			</div>
		<?php
		else :
			echo esc_html__('Sorry, no posts matched your criteria.', 'academist-core');
		endif;

		wp_reset_postdata();

		?>
	</div>
</div>