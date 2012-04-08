<?php

/*
	Template Name: Index Template
*/

 get_header(); ?>
		<div class="jbasewrap index">
			
			
			<?php
			/*
				pseudocode:
				
				start letters
					get tags 
					for each tag 
						get tag's 1st letter
						
						if letter != previous tag's 1st letter
							start letter
								start entries
						endif
									start entry
										echo tag
										query posts with tag
										while have posts
											echo post link
										endwhile
									end entry
									
								if letter != previous tag's first letter										
								
									end entries
								end letter
								
								endif
					endforeach
				end letters
			*/
			?>
			
			
			
			<ul class="letters">
			<?php 
			$prev_letter = '';
			$prev_row = '';
			$i = 0;
			$tags = get_tags();
			$letters = array();
			foreach ($tags as $tag){
				
				$tag_link = get_tag_link($tag->term_id);
				$tagname = $tag->name;
				$letter = strtoupper(substr($tagname,0,1));
				$letters[] = $letter;
				
				if ($i != 0) { 
					if ($letter != $prev_row) { 
				?>
					
						</li>	<!-- / letter -->
					</ul>	<!-- / entries -->
				<?php } 
				}
				$i++; ?>
				
				
				<?php
				if ($letter != $prev_row) { ?>
					
				<li class='letter'><h2><a name='<?php echo ($letter); ?>'></a><?php echo ($letter); ?></h2>
					
					<ul class='entries'>
				<?php } ?>
						
						<?php if ($letter != $prev_row) { ?>
						</li><!-- / entry -->
						<?php } ?>
						<li class='entry'><span><?php echo ($tagname); ?></span>
							
							<?php
							$query = new WP_Query( "tag_id={$tag->term_taxonomy_id}" ); ?>
				
							<ul class="references">
							<?php
							// The Loop
							while ( $query->have_posts() ) : $query->the_post(); ?>
							
								<li class='reference'>
									<h4 class='small'>
										<a href="<?php echo ($post->guid); ?>"><?php echo ($post->post_title); ?></a>
									</h4>
								</li><!-- / reference -->
								
							<?php endwhile; ?>
							</ul><!-- / references -->
				<?php 			
				$prev_row = $letter; 
				}	?>					
				</ul><!-- / final entries ul -->	
			</ul><!-- / letters -->	
			
			
			
			
			<ul class="indexNav">
			<?php
			foreach ($letters as $letter) {
				if ($letter != $prev_letter) {
					echo "<li><a href='#{$letter}'>{$letter}</a></li>";
					$prev_letter = $letter;
				}
			}
			?>
			</ul>
		</div>


<?php get_footer(); ?>