<div class="row">
    <?php
        $polls_count = count($polls_found);
        $profiles_count = count($profiles_found);
        if ($polls_count + $profiles_count == 0) {
            echo '<h2>Sorry, No results found.<h2>';
        } else {
            echo "<h1>Search results with keyword: \"{$key_word}\"<h1>";
        }
        if ($polls_count) {
            echo "<h3>Polls ({$polls_count})</h3>";
            echo '<div class="none"></div>';
            foreach ($polls_found as $po) {
                echo '<div class="alert content-item">';
                $poll = $po[0];
                $attr = $po[1];
                echo "<b>{$poll->createViewLink()}</b>";
                echo "<br/>Description: <i>{$poll->description}</i>";
                echo '</div>';
            }
        }
        
        if ($profiles_count) {
            echo "<h3>Profiles ({$profiles_count})</h3>";
            foreach ($profiles_found as $pf) {
                echo '</br>';
                $profile = $pf[0];
                $attr = $pf[1];
                echo $profile->createViewLink($profile->{$attr});
            }
        }
    ?>
</div>