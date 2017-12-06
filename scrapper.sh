#!/usr/bin/env bash
curl -vs 2>&1 http://simpel.dephub.go.id/index.php/Dashboard | grep -E '^\s+var\s(texx|koordinat|titlee|lng|lat|link|nama)\s=.*' | sed "s/^[ t]*//" > scrapped.js
