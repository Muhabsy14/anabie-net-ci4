<?php if (session()->getFlashdata('success')): ?>
<div class="mb-md p-md rounded-lg bg-green-50 border border-green-200 text-green-800 text-sm"><?= esc(session()->getFlashdata('success')) ?></div>
<?php endif; ?>
<?php if (session()->getFlashdata('error')): ?>
<div class="mb-md p-md rounded-lg bg-red-50 border border-red-200 text-red-800 text-sm"><?= esc(session()->getFlashdata('error')) ?></div>
<?php endif; ?>
<?php if (session()->getFlashdata('errors')): ?>
<div class="mb-md p-md rounded-lg bg-red-50 border border-red-200 text-red-800 text-sm">
<ul class="list-disc pl-md">
<?php foreach ((array) session()->getFlashdata('errors') as $err): ?>
<li><?= esc(is_array($err) ? implode(', ', $err) : $err) ?></li>
<?php endforeach; ?>
</ul>
</div>
<?php endif; ?>
