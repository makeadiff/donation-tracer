# Donation Tracer

This is a dev tool to debug Donut donations. This can be used to search for donations, deposits, donors, users, etc. You can edit/delete many things directly here. 

## Components

* Assigner.php: Lets you search for a user - and shows everyone they are assigned to and everyone assigned to them(no longer in use after we moved to a deposit format). Also, lets you change their role assignments)
* change_fundraiser: Fix tool - Some people are having issues with signing into old id when donuting. So their donation goes to the old volunteers name. This scirpt lets you change the fundraiser on donations after a given date.
* city_view.php: A tool to quickly assign Finance Fellows and Coaches to any city with hirarchy(hirarcy is depricated thanks to deposit structure.)
* donation.php
* donors.php
* users.php

## USE WITH CARE

This bypasses a lot of validation that are there in the actual app. This is meant to be used only by people who KNOW WHAT THEY ARE DOING. 

# Owner

* Binny

# Dependencies

* Iframe
* Apps/common
