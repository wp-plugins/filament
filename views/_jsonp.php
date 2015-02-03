<?php if( $content_type == "jsonp" ) echo "{$callback}("; ?><?php echo $data; ?><?php if( $content_type == "jsonp" ) echo ")"; ?>
