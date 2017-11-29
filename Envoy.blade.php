@servers(["web"=>"deploybot@172.104.152.202"])

@task("deploy-prod", ["on"=>"web"])

cd extramile_production/nerd6-runningapp
git reset --hard HEAD~1
git pull

@endtask

@task("deploy-stag", ["on"=>"web"])

cd extramile_staging/nerd6-runningapp
git reset --hard HEAD~1
git pull

@endtask