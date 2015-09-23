<div class="top-block">
    <?php echo $user->name;?>
    <div class="karma">
        <span class="label"><?php echo $user->karma;?> karma</span>
    </div>
    <?php
    switch ($connection) {
        case 'accepted':
            echo "You are friends";
            break;
        case 'requested':
            echo "You have requested to be friends";
            break;
        case 'friend-request':
            echo "This person has requested to be friends";
            break;
        case 'self':
            echo "This is youre profile";
            break;
        default:
            echo "Send a friend request";
            break;
    }
    ?>
</div>
<div class="block">
</div>