<?php

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$roleDosen = \Spatie\Permission\Models\Role::findByName("dosen");
$dosenPermissions = \Spatie\Permission\Models\Permission::where("name", "like", "%:Course")
    ->orWhere("name", "like", "%:ForumTopic")
    ->orWhere("name", "like", "%:QuestionBank")
    ->get();
$roleDosen->syncPermissions($dosenPermissions);

$roleMhs = \Spatie\Permission\Models\Role::findByName("mahasiswa");
$mhsPermissions = \Spatie\Permission\Models\Permission::where("name", "like", "%:MyCourse")
    ->get();
$roleMhs->syncPermissions($mhsPermissions);

echo "Permissions assigned!\n";
