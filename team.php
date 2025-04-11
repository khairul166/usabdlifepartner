<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @package YourThemeName
 * 
 * Template Name: Teams
 */

get_header(); ?>

<section id="center" class="team_pg  pt-5 pb-5">
   <div class="container-xl">
	    <h1 class="theme-text-color text-center mb-4">OUR TEAM</h1>
		<div class="row team_1 mx-3">
		<?php
		$team_members = cs_get_option('team_members');

if (!empty($team_members)) :
  foreach ($team_members as $member) :
    $name         = esc_html($member['name']);
    $designation  = esc_html($member['designation']);
    $qualification = esc_html($member['qualification']);
    $experience   = esc_html($member['experience']);
    $about        = esc_html($member['about']);
    $image        = esc_url($member['image']);
    $socials = [
      'facebook'  => $member['facebook'] ?? '',
      'twitter'   => $member['twitter'] ?? '',
      'linkedin'  => $member['linkedin'] ?? '',
      'instagram' => $member['instagram'] ?? '',
      'youtube'   => $member['youtube'] ?? '',
    ];
    ?>

    <div class="col-md-6 mt-4">
      <div class="team_1i">
        <div class="team_1i1 row">
          <div class="col-md-6 col-sm-6 pe-0">
            <div class="team_1i1l position-relative">
              <div class="team_1i1li">
                <a href="#"><img src="<?php echo $image; ?>" class="img-fluid" alt="<?php echo $name; ?>"></a>
              </div>
              <div class="team_1i1li1 position-absolute w-100 h-100 bg_back top-0 text-center">
                <div class="top_1r">
                  <ul class="mb-0">
                    <?php foreach ($socials as $platform => $url) :
                      if (!empty($url)) : ?>
                        <li class="d-inline-block">
                          <a class="bg-white d-block rounded-circle text-center theme-text-color" href="<?php echo esc_url($url); ?>" target="_blank">
                            <i class="bi bi-<?php echo esc_attr($platform); ?>"></i>
                          </a>
                        </li>
                    <?php endif; endforeach; ?>
                  </ul>
                </div>
              </div>
            </div>
          </div>

          <div class="col-md-6 col-sm-6 ps-0">
            <div class="team_1i1r bg_light px-4">
              <h5><?php echo $name; ?></h5>
              <h6 class="font_14"><?php echo $designation; ?></h6>
              <hr class="line">
              <h6 class="font_14"><span class="fw-bold">Qualification:</span> <?php echo $qualification; ?></h6>
              <h6 class="font_14 mb-0 mt-2"><span class="fw-bold">Experience:</span> <?php echo $experience; ?></h6>
              <p class="mb-0 mt-3"><?php echo $about; ?></p>
            </div>
          </div>
        </div>
      </div>
    </div>

  <?php
  endforeach;
endif;
?>
   </div>
 </section>

 <?php get_footer(); ?>