if (!(Test-Path ".\artisan" -PathType Leaf)) {
  echo "ERROR: Artisan not found in this directory"
  exit
}

$input = Read-Host -Prompt "Enter model names separated by commas"

if (!$input) {
  echo "ERROR: No model names entered"
  exit
}

echo "Enter switches to create additional classes (like -msfc)"
$switch = Read-Host -Prompt "Enter the desired switches"

if (!$switch) {
  echo "WARNING: No switch selected"
} else {
  if ($switch -notcontains "-") {
    $switch = "-" + $switch
  }
  if ($switch -notmatch "[mscf]") {
    echo "ERROR: The switch can contain only [mscf] characters"
    exit
  }
}

$input = $input -replace '\s',''
$switch = $switch -replace '\s',''
$models = $input.Split(",")

foreach ($model in $models) {
  echo "Creating model $model"
  php artisan make:model $model $switch
}