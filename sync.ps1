# ============================================================
# sync.ps1
# ------------------------------------------------------------
# Copies your REAL, working project folders (from XAMPP's htdocs,
# where Apache actually serves them from) into this Git repo folder,
# so Git always has an up-to-date copy to commit from.
#
# Run this BEFORE every git add/commit/push, whenever you've
# changed files in htdocs since the last sync.
# ============================================================

# robocopy = "robust copy", Windows' built-in tool for reliably
# copying whole folder trees (handles subfolders, retries on
# locked files, etc. better than a plain copy command).
#
# Syntax: robocopy <source> <destination> <options>
#
# /E    = include empty subfolders too, not just ones with files
# /XD   = eXclude Directory — never touch this repo's own .git
#         folder, or shoppn's old separate .git folder if it's
#         still sitting there from before

Write-Host "Syncing shoppn..." -ForegroundColor Cyan
robocopy C:\xampp\htdocs\shoppn shoppn /E /XD .git

Write-Host "Syncing lab01-events-manager..." -ForegroundColor Cyan
robocopy C:\xampp\htdocs\events_manager lab01-events-manager /E /XD .git lab01-events-manager

Write-Host "Sync complete. Now review with 'git status' before adding/committing." -ForegroundColor Green