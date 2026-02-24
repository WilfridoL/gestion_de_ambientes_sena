<?php switch ($mssg) {
  case 'success':
?>
    <div role="alert" class="border-2 bg-green-100 p-4 text-green-900 shadow-[4px_4px_0_0]">
      <div class="flex items-start gap-3">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" class="mt-0.5 size-4">
          <path fill-rule="evenodd" d="M8 15A7 7 0 1 0 8 1a7 7 0 0 0 0 14Zm3.844-8.791a.75.75 0 0 0-1.188-.918l-3.7 4.79-1.649-1.833a.75.75 0 1 0-1.114 1.004l2.25 2.5a.75.75 0 0 0 1.15-.043l4.25-5.5Z" clip-rule="evenodd"></path>
        </svg>

        <strong class="block flex-1 leading-tight font-semibold">
          <?= $msg ?>
        </strong>
      </div>
    </div>
  <?php
    break;

  default:
  ?>
    <div role="alert" class="border-2 bg-red-100 p-4 text-red-900 shadow-[4px_4px_0_0]">
      <div class="flex items-start gap-3">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" class="mt-0.5 size-4">
          <path fill-rule="evenodd" d="M6.701 2.25c.577-1 2.02-1 2.598 0l5.196 9a1.5 1.5 0 0 1-1.299 2.25H2.804a1.5 1.5 0 0 1-1.3-2.25l5.197-9ZM8 4a.75.75 0 0 1 .75.75v3a.75.75 0 1 1-1.5 0v-3A.75.75 0 0 1 8 4Zm0 8a1 1 0 1 0 0-2 1 1 0 0 0 0 2Z" clip-rule="evenodd"></path>
        </svg>

        <strong class="block flex-1 leading-tight font-semibold">
          <?= $msg ?>

        </strong>
      </div>
    </div>
<?php
    break;
} ?>