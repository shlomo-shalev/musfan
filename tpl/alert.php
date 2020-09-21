<?php $warning = $warning ?? false ?>
<?php if($warning): ?>
    <div class="toast mt-3 position-fixed bottom-10 right-10">
    <div class="toast-header text-light bg-cs1">
    Alerts
        <button type="button" class="mr-2 close position-absolute right-0 top-0 text-light" data-dismiss="toast">&times;</button>
    </div>
    <div class="toast-body bg-light p-20">
    <?= $warning ?>
    </div>
  </div>
  <?php unset($_SESSION['warning']); ?>
<?php endif; ?>