<div class="top-block">
    <h2>Vrienden met de meeste karma</h2>
    <div class="friends">
        <?php foreach($friends as $friend) {
            echo $this->element('friend', ['friend' => $friend]);
        }?>
    </div>
</div>
<div class="block">
</div>