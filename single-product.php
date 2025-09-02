<?php
$title                 = get_the_title();
$is_eng_lang           = ! empty( get_field( 'article-is-english' ) ) ? get_field( 'article-is-english' )[0] : '';
$pubid                 = get_field( 'article-openpdc-id' );
$pubimagesrc           = get_field( 'article-openpdc-imgsrc' );
$modificationdate      = get_field( 'article-openpdc-modification-date' );
$pubdefaultdescription = get_field( 'article-openpdc-description' );
$puburl                = get_field( 'openpdc-url', 'options' );
$puburl               .= 'items/' . $pubid . '?' . urlencode( $modificationdate );
$pubjson               = file_get_contents( $puburl );
$pubcontent            = $pubdefaultdescription;
$pubdownloads          = false;
$publinks              = false;
$pubforms              = false;
$publocations          = false;
$pubfaq                = false;
$pubappointment        = false;
$pubidentifications    = false;

if ( false === $pubjson ) {
	// use fallback $pubcontent
} else {
	$contents = json_decode( $pubjson );
	if ( isset( $contents->content ) && empty( $contents->content ) ) {
		// use fallback $pubcontent
	} else {
		$pubcontent  = $contents->content;
		$title       = $contents->title;
		$pubimages   = (array) $contents->image;
		$pubimagesrc = ! empty( $pubimages ) ? $pubimages['rendered'] : $pubimagesrc;

		if ( ! empty( $contents->image ) ) {
			$pubimages       = (array) $contents->image->meta->sizes;

			if ( ! empty( $pubimages ) ) {
				if ( $pubimages['strl-large'] ) {
					//rendered is not available for sizes in Openpdc.
					if ( ! empty( $pubimages['strl-large']->rendered ) ) {
						$pubimagesrc = $pubimages['strl-large']->rendered;
					} else {
						$src         = $pubimages['strl-large']->url;
						$height      = $pubimages['strl-large']->height;
						$width       = $pubimages['strl-large']->width;
						$alt         = $contents->image->alt;
						$pubimagesrc = '<img src="' . $src . '" height="' . $height . '" width="' . $width . '" alt="' . $alt . '" class="attachment-large size-large" decoding="async" loading="lazy">';
					}
				}
			}
		}
		$modificationdate = $contents->date_modified;
	}

	if ( ! empty( $contents->downloads ) ) {
		$pubdownloads = $contents->downloads;
	}

	if ( ! empty( $contents->links ) ) {
		$publinks = $contents->links;

		$external_links = array();
		$internal_links = array();

		if ( $publinks ) {
			foreach ( $publinks as $link ) {
				if ( strpos( $link->url, get_bloginfo( 'wpurl' ) ) !== false ) {
					$internal_links[] = array(
						'title' => $link->title,
						'url'   => $link->url,
					);
				} else {
					$external_links[] = array(
						'title' => $link->title,
						'url'   => $link->url,
					);
				}
			}
		}
	}

	if ( ! empty( $contents->forms ) ) {
		$pubforms = $contents->forms;
	}

	if ( ! empty( $contents->locations ) ) {
		$publocations = $contents->locations;
	}

	if ( ! empty( $contents->faq ) ) {
		$pubfaq = $contents->faq;
	}

	if ( ! empty( $contents->appointment ) ) {
		$pubappointment = $contents->appointment;
	}

	if ( ! empty( $contents->identifications ) ) {
		$pubidentifications = $contents->identifications;
	}
}

get_header();

if ( post_password_required() ) {
	?>
	<div class="grid-container">
		<div class="grid-x grid-margin-x">
			<div class="cell medium-8">
				<?php echo get_the_password_form( $post->ID ); ?>
			</div>
		</div>
	</div>
	<?php
} else {
	while ( have_posts() ) {
		the_post();
		if ( ! empty( $pubimagesrc ) ) {
			?>
			<section class="article-header-image">
				<div class="grid-x grid-margin-x">
					<div class="cell">
						<div class="imagewrapper">
							<?php echo $pubimagesrc; ?>
						</div>
					</div>
				</div>
			</section>
			<?php
		}
		?>
			<section class="single-article-content single-article" <?php echo $is_eng_lang ? 'lang="en"' : ''; ?>>
				<div class="grid-x grid-margin-x">
					<div class="cell large-3 large-offset-1 large-order-2 small-order-1 sidebar">
					<?php
					if ( $pubappointment && $pubappointment->active ) {
						?>
					<a class="btn quaternary icon" href="<?php echo $pubappointment->url . ( ! empty( $pubappointment->meta ) ? '?' . $pubappointment->meta : '' ); ?>" target="_self"><?php echo $pubappointment->title; ?></a>
					</br></br>
						<?php

					}
					?>
					<?php
					if ( $pubforms ) {
						foreach ( $pubforms as $pubform ) {
							?>
					<a class="btn quaternary icon" href="<?php echo $pubform->url; ?>" target="_self"><?php echo $pubform->title; ?></a>
					</br></br>
								<?php
						}
					}

					if ( $internal_links ) {
						?>
						<div class="widget">
							<div class="widget-title"><?php _e( 'Links', 'strl-frontend' ); ?></div>
							<div class="widget-content">
								<ul>
								<?php
								foreach ( $internal_links as $link ) {
									?>
									<li><a class="" href="<?php echo $link['url']; ?>"><?php echo $link['title']; ?></a></li>
									<?php
								}
								?>
								</ul>
							</div>
						</div>
						<?php
					}
					?>
					</div>
					<div class="cell large-8 large-order-1 small-order-2">
						<div class="article-inner">
							<div class="article-intro">
								<h1><?php echo $title; ?></h1>
							</div>
							<?php
							if ( ! empty( $pubcontent ) ) {
									global $pubcontent;
									get_template_part( 'blocks/textonly/textonly' );
							}
							?>
							<?php
							if ( ! empty( $publocations ) ) {
								?>
							<section class="textonly-featured">
								<div class="grid-x grid-margin-x ">
									<div class="cell">
										<div class="text">
											<?php
											foreach ( $publocations as $location ) {
												$location_title              = $location->title;
												$location_description        = $location->general->description;
												$location_street             = $location->location->street;
												$location_postalcode         = $location->location->postalcode;
												$location_maplink            = $location->location->maplink;
												$location_phone              = $location->communication->street;
												$location_whatsapp           = $location->communication->postalcode;
												$location_email              = $location->communication->maplink;
												$location_openinghours       = $location->openinghours;
												$location_customopeninghours = $location->{'custom-openinghours'};
												?>
													<h2><?php echo $location_title; ?></h2>
													<?php if ( ! empty( $location_description ) ) { ?>
														<p><?php echo $location_description; ?></p>
													<?php } ?>
													<h3><?php _e( 'Address', 'strl-frontend' ); ?></h3>
													<address>
													<?php if ( ! empty( $location_street ) ) { ?>
														<?php echo  $location_street; ?><br>
													<?php } ?>
													<?php if ( ! empty( $location_postalcode ) ) { ?>
														<?php echo  $location_postalcode; ?><br>
													<?php } ?>
													<?php if ( ! empty( $location_maplink ) ) { ?>
														<a href="<?php echo $location_maplink; ?>" target="_blank"><?php _e( 'View on Google Maps', 'strl-frontend' ); ?></a><br><br>
													<?php } ?>
													<?php if ( ! empty( $location_phone ) ) { ?>
														<a href="tel:<?php echo $location_phone; ?>" target="_blank"><?php _e( 'Phone', 'strl-frontend' ); ?></a><br>
													<?php } ?>
													<?php if ( ! empty( $location_whatsapp ) ) { ?>
														<a href="https://wa.me/<?php echo $location_whatsapp; ?>" target="_blank"><?php _e( 'Whatsapp', 'strl-frontend' ); ?></a><br>
													<?php } ?>
													<?php if ( ! empty( $location_email ) ) { ?>
														<a href="mailto:<?php echo $location_email; ?>" target="_blank"><?php _e( 'Email', 'strl-frontend' ); ?></a><br>
													<?php } ?>
													</address>
													<?php if ( ! empty( $location_openinghours ) ) { ?>
													<p>
															<h3><?php _e( 'Opening hours', 'strl-frontend' ); ?></h3>
															<?php if ( true === $location_openinghours->{ 'message-active' } ) { ?>
																<?php echo $location_openinghours->message; ?><br>
																<?php } ?>
																<?php if ( ! empty( $location_openinghours->messages ) ) { ?>
																	<?php if ( ! empty( $location_openinghours->messages->open ) ) { ?>
																		<?php echo $location_openinghours->messages->open->today; ?><br>
																		<?php echo $location_openinghours->messages->open->tomorrow; ?><br>
																		<?php } ?>
																<?php } ?>
																<ul>
																<?php
																foreach ( $location_openinghours->days as $key => $day ) {
																	if ( ! empty( $day->{'open-time'} ) ) {
																		?>
																	<li><strong><?php _e( $key, 'strl-frontend' ); ?></strong><br>
																		<?php
																		if ( $day->closed === true ) {
																			echo $day->message;
																		} else {
																			echo 'open: ' . $day->{'open-time'};
																			echo '<br>gesloten na: ' . $day->{'closed-time'};
																		}
																		?>
																	</li>
																		<?php
																	}
																}
																?>
																</ul>
													</p>
													<?php } ?>
													<p>
														<?php if ( ! empty( $location_customopeninghours ) ) { ?>
															<h3><?php _e( 'Custom opening hours', 'strl-frontend' ); ?></h3>
															<?php if ( true === $location_customopeninghours->{ 'message-active' } ) { ?>
																<?php echo $location_customopeninghours->message; ?><br>
																<?php } ?>
																<?php if ( ! empty( $location_customopeninghours->messages ) ) { ?>
																	<?php if ( ! empty( $location_customopeninghours->messages->open ) ) { ?>
																		<?php echo $location_customopeninghours->messages->open->today; ?><br>
																		<?php echo $location_customopeninghours->messages->open->tomorrow; ?><br>
																		<?php } ?>
																<?php } ?>
																<ul>
																<?php
																foreach ( $location_customopeninghours->days as $key => $day ) {
																	if ( ! empty( $day->{'open-time'} ) ) {
																		?>
																	<li><strong><?php _e( $key, 'strl-frontend' ); ?></strong><br>
																		<?php
																		if ( $day->closed === true ) {
																			echo $day->message;
																		} else {
																			echo 'open: ' . $day->{'open-time'};
																			echo '<br>gesloten na: ' . $day->{'closed-time'};
																		}
																		?>
																	</li>
																		<?php
																	}
																}
																?>
																</ul>
															<?php } ?>
													</p>
													<?php
											}
											?>
										</div>
									</div>
								</div>
							</section>
							<?php } ?>

							<?php
							if ( ! empty( $pubfaq ) ) {
								?>
								<section class="faq-select">
									<div class="grid-x grid-padding-x">
											<div class="cell ">
												<div class="inner">
													<?php
													foreach ( $pubfaq as $faq ) {
														$question = $faq->question;
														$answer   = $faq->answer;

														// Remove the &nbsp; from the answer, the &nbsp; came out of the API as a string.
														$nbsp   = html_entity_decode( '&nbsp;' );
														$answer = str_replace( $nbsp, ' ', $answer );
														if ( ! empty( $question ) ) {
															?>
															<details>
																<summary>
																	<h3><?php echo $question; ?></h3>
																	<i class="fa-regular fa-angle-down" aria-hidden="true"></i>
																</summary>
																<div>
																	<div class="text">
																		<?php echo $answer; ?>
																	</div>
																</div>
															</details>
															<?php $answer_strip = str_replace( '"', "'", $answer ); ?>
															<script type="application/ld+json">
															{
																"@context": "https://schema.org",
																"@type": "Question",
																"name": "<?php echo $question; ?>",
																"acceptedAnswer": {
																	"@type": "Answer",
																	"text": "<?php echo $answer_strip; ?>"
																}
															}
															</script>
															<?php
														}
													}
													?>
												</div>
											</div>
										</div>
									</section>
							<?php } ?>

							<section class="downloads">
							<?php
							if ( ! empty( $external_links ) || ! empty( $pubdownloads ) ) {
								?>
								<ul class="downloads-list">
								<?php
								foreach ( $pubdownloads as $download ) {
									if ( ! empty( $download ) ) {
										get_template_part(
											'blocks/_global/download-link',
											'',
											array(
												'link_url' => $download->url,
												'link_title' => $download->title,
												'link_type' => 'download',
											),
										);
									}
								}

								foreach ( $external_links as $external_link ) {
									if ( ! empty( $external_link ) ) {
										get_template_part(
											'blocks/_global/download-link',
											'',
											array(
												'link_url' => $external_link['url'],
												'link_title' => $external_link['title'],
												'link_type' => 'link',
											),
										);
										?>
										<?php
									}
								}
								?>
								</ul>
								<?php
							}
							?>
							</section>
						</div>
					</div>
				</div>
			</section>

		<?php
		get_template_part( 'blocks/contact/contact' );
	}
}

get_footer();
