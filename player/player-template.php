<?php
/*
Template Name: Radio Player
*/
?>
<!doctype HTML>
<head>
  <title>Listen live | Smoke Radio</title>
  <link href="<?php echo get_template_directory_uri(); ?>/player/player.css" rel="stylesheet"/>
  <script src="https://use.typekit.net/twm4qpo.js"></script>
  <script>try{Typekit.load({ async: true });}catch(e){}</script>


	<meta property="fb:app_id" content="1134129026651501" />
  <meta property="og:url" content="http://smokeradio.co.uk/"/>
  <meta property="og:title" content="Listen Live | Smoke Radio" />
  <meta property="og:site_name" content="Smoke Radio" />
  <meta property="og:description" content="On campus, online, and on your mobile." />
  <meta property="og:type" content="website" />
  <meta property="og:image" content="<?php echo get_template_directory_uri() ?>/img/poster-radio.jpg" />
  <meta name="twitter:card" content="summary_large_image">
  <meta name="twitter:site" content="@Smoke_Radio">
  <meta name="twitter:creator" content="@Smoke_Radio">
  <meta name="twitter:title" content="Smoke Radio">
  <meta name="twitter:description" content="On campus, online, and on your mobile.">
  <meta name="twitter:image" content="<?php echo get_template_directory_uri() ?>/img/poster-radio.jpg" >





  <?php wp_head(); ?>
</head>
<body>
  <script>
    jQuery(document).ready(function(){
      // A function to fill in show data using Marconi API
      function showInfoData(){
        // Make the ajax request
        jQuery.ajax({url: "https://marconi.smokeradio.co.uk/api/now_playing.php", success: function(result){
          // Check if there's a show on air
          var showExists = result.success;
          // If there's a show on air, show the (normally hidden) box
          if (showExists == 1){
            // Display the programme info box
            jQuery("#programme-info").css("display", "block");
            // Pull specific fields from API and process for display
            var rawTime = result.show.tx_time;
            var time = "From ".concat(rawTime.slice(0,-3));
            var title = result.show.title;
            var desc = result.show.short_desc;
            // Display processed data
            jQuery("#programme-info h4").html(time);
            jQuery("#programme-info h3").html(title);
            jQuery("#programme-info p").html(desc);
          } else {
            jQuery("#programme-info").css("display", "block");

            var h = new Date().getHours();
            var hend = h + 1;
            jQuery("#programme-info h4").html(h + ":00 - " + hend + ":00");

            jQuery("#programme-info h3").html("Non-stop music");
            jQuery("#programme-info p").html("The best tracks from Smoke Radio's catalogue.");
          }
        }});
        // Check for new data every 60 seconds
        setTimeout(showInfoData, 60000);
      }
      // Call the function
      showInfoData();
      // A function to fill in track data using Icecast API
      function nowPlayingData(){
        // Make the ajax request
        jQuery.ajax({url: "http://airtime.smokeradio.co.uk:8080/status-json.xsl?mount=/listen", dataType: "text",  success: function(result){
          // Fix the shoddy coding of the JSON API
          var correctjson = result.replace((/-,/g), '"-",');
          // And re-encode the response back into proper JSON
          correctjson = JSON.parse(correctjson);
          // Save the track artist and title string to a single var
          var rawInfo = correctjson.icestats.source.title;
          // If the var isn't set or is set to "Off air", hide the track info box
          if (rawInfo == undefined || rawInfo == "-") {
            jQuery("#now-playing").css("display", "none");
          } else if(rawInfo == "Off air") {
            jQuery("#now-playing").css("display", "block");
            jQuery("#now-playing h4 i").css("display", "none");
            jQuery("#now-playing h4 span").html("We'll be back soon");
            jQuery("#now-playing h3").html("Off air");
          } else {
            // Show the box
            jQuery("#now-playing").css("display", "block");
            // Remove weird leading hyphen Airtime sometimes puts there for kicks
            String.prototype.trimLeft = function(charlist) {
              if (charlist === undefined)
                charlist = "- ";
              return this.replace(new RegExp("^[" + charlist + "]+"), "");
            };
            rawInfo = rawInfo.trimLeft();
            // Split var into track name and artist
            var processedInfo = rawInfo.split(" - ");
            // Display the result string in a div of given ID
            if (showExists == 0){
              jQuery("#now-playing h3").html('aaaar');
              jQuery("#now-playing h4 span").html('aaaaa');
            }
          }
        }});
        // Check for new data every 10 seconds
        setTimeout(nowPlayingData, 10000);
      }
      // Call the function
      //nowPlayingData();
  // End document-ready function
  });
  </script>

  <main>
    <section id="ident">
      <img src="<?php echo get_template_directory_uri(); ?>/img/radio.png" alt="Smoke Radio">
    </section>


<!-- HERE'S THE TRICKY BIT -->

<?php
if (get_option('second_stream')) {
// If a second stream is specified, do this
?>

  <section id="media">
    <!-- Default audio element. Switch managed with JS -->
    <audio id="audio" src="<?php echo get_option('stream_url'); ?>" autoplay>
      Whoops! Looks like your browser is a bit too dated to tune in. Update to <a href="http://chrome.google.com">something more modern?</a>
    </audio>
    <p id="pick">Pick your channel...</p>
    <!-- Stream switch control -->
    <section id="switch">
      <div id="first" class="on" onclick="playFirst()" style="background-image:url('<?php echo get_template_directory_uri(); ?>/img/radio.png')">
      </div>
      <div id="second" onclick="playSecond()" style="background-image:url('<?php echo get_option('second_stream_img'); ?>')">
      </div>
    </section>
  </section>

  <script>
    var audio = document.getElementById('audio');
    var firstDiv = document.getElementById('first');
    var secondDiv = document.getElementById('second');
    // var volcontrol = document.getElementById('vol-control');
    // Play pause control
    function playFirst() {
        audio.src = '<?php echo get_option('stream_url'); ?>';
        audio.play();
        secondDiv.className="";
        firstDiv.className="on";
    }
    // Play pause control
    function playSecond() {
        audio.src = '<?php echo get_option('second_stream'); ?>';
        audio.play();
        firstDiv.className="";
        secondDiv.className="on";
    }
  </script>

<?php
// If there is no second stream specified, do this instead
}else{
?>
    <section id="media">
      <!-- The audio element -->
      <?php
      if(get_option('stream_type') == 'HTTP'){
        ?>

        <!-- Audio element -->
        <audio id="audio" autoplay>
          <source src="<?php echo get_option('stream_url'); ?>" type="audio/aac"></source>
          Whoops! Looks like your browser is a bit too dated to tune in. Update to <a href="http://chrome.google.com">something more modern?</a>
        </audio>

        <section id="controls">
          <!-- Play/pause control -->
          <div id="play-pause" onclick="play()"><i id="state-icon" class="fa fa-pause"></i></div>
          <!-- Volume control -->
          <!-- <i class="fa fa-volume-up"></i> -->
          <!-- <input type="range" id="vol-control" min="0" max="100" value="100" step="1" oninput="setvolume(this.value)" onchange="setvolume(this.value)"/> -->
        </section>

        <script>
          var playpause = document.getElementById('play-pause');
          var audio = document.getElementById('audio');
          var icon = document.getElementById('state-icon');
          // var volcontrol = document.getElementById('vol-control');

          // Play pause control
          function play() {
            if (audio.paused) {
              audio.play();
              icon.className="";
              icon.className="fa fa-pause";
            } else {
              audio.pause();
              icon.className="";
              icon.className="fa fa-play";
            }
        	}


          // // Volume control
          // function setvolume(val){
          //     audio.volume = val / 100;
          // }
        </script>

        <?php
      } else {
        ?>
        <div id="videoPlayer">Loading the audio player</div>
  			<script type="text/javascript">
  				var playerInstance = jwplayer("videoPlayer");
  				playerInstance.setup({
  				file: "<?php echo get_option('stream_url') ?>",
  				width: 300,
  				height: 35,
  				name: 'smokeplayerskin',
          stretching: "fill",
          autostart: 1
  				});
  			</script>
        <?php
      }
      ?>
    </section>
<?php
}
?>







    <section id="data">
      <!-- Marconi-powered progamme info widget -->
      <?php
      if (get_option('schedule_override')) {
        ?>
        <div id="programme-info-override" style="display:block;">
          <h4>Special</h4>
          <h3><?php echo get_option('schedule_override'); ?></h3>
          <p><?php echo get_option('schedule_override_desc'); ?></p>
        </div>
        <?php
      } else{
        ?>
        <div id="programme-info">
          <h4></h4>
          <h3></h3>
          <p></p>
        </div>
        <?php
      }
      ?>

      <!-- Icecast-powered current track widget -->
      <div id="now-playing">
        <h4><i class='fa fa-music'></i> <span></span></h4>
        <h3></h3>
      </div>
    </section>
    <section id="social">
      <!-- Social media -->
      <!-- Facebook share button script -->
      <div id="fb-root"></div>
      <script>(function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s); js.id = id;
        js.src = "//connect.facebook.net/en_GB/sdk.js#xfbml=1&version=v2.8&appId=1134129026651501";
        fjs.parentNode.insertBefore(js, fjs);
      }(document, 'script', 'facebook-jssdk'));</script>
      <iframe id="twitter-widget-0" scrolling="no" frameborder="0" allowtransparency="true" class="twitter-mention-button twitter-mention-button-rendered twitter-tweet-button" title="Twitter Tweet Button" src="http://platform.twitter.com/widgets/tweet_button.3748f7cda49448f6c6f7854238570ba0.en.html#dnt=true&amp;id=twitter-widget-0&amp;lang=en&amp;original_referer=http%3A%2F%2Fuwsu.com%2Fplayer%2Findex.php&amp;screen_name=Smoke_Radio&amp;size=m&amp;time=1482379632841&amp;type=mention" style="position: static; visibility: visible; width: 156px; height: 20px;" data-screen-name="Smoke_Radio"></iframe>
      <div class="fb-like" data-href="https://smokeradio.co.uk" data-layout="button_count" data-action="like" data-size="small" data-show-faces="true" data-share="false"></div>
    </section>
  </main>




  <?php wp_footer(); ?>

</html>
