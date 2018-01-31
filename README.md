# Simple Share Buttons Light

_One of the fastest WordPress share button plugins available._

This is a fork of legacy [Simple Share Buttons Light](https://github.com/wp-plugins/simple-share-buttons-light) plugin by [Simple Share Buttons](https://simplesharebuttons.com/) that is not available anymore in WordPress Plugin Directory.

## Requirements
* [WordPress](https://wordpress.org/) 4.4 or newer

## Description (copied from legacy readme.txt)

You have just stumbled across one of the fastest WordPress share button plugins available - when speed is a priority, you needn’t think twice, Simple Share Buttons Light is blazingly fast.

The aim was pretty straight-forward: Create one of, if not the fastest share buttons plugin, whilst keeping the core functionality everyone will expect – pick and choose share buttons and have a couple of choices for how they will appear.

How can we put this… under 5 milliseconds! Yes, seriously – Simple Share Buttons Light loads in under 0.005 seconds consistently.

As you would expect, this level of speed does come at the cost of some features, if you need more then checkout the [Adder](https://wordpress.org/plugins/simple-share-buttons-adder/) and [Plus](https://simplesharebuttons.com/plus/) versions.

## Changelog

### ?.?.? (????-??-??)
* New: filter ssbl_show_buttons that can be used to override decision if buttons should be shown or not
* Change: use wp_get_document_title() as fallback when no explicit title is provided via shortcode
* Required WordPress version is now 4.4

### 1.0.0 (2017-03-01)
* Fix: no buttons were shown under certain conditions (https://wordpress.org/support/topic/ssbl-no-button-images-showing/)
* Fix: correctly encode title for use in subject argument of "mailto:" links
* Tested up to WordPress 4.7.2

### 1.0.0.alpha (2017-03-01)
* Fork of legacy plugin created at https://github.com/chesio/simple-share-buttons-light
* No code changes: this version is functionally equivalent to version 0.0.2

### 0.0.2
* Update: New Google+ branded buttons

### 0.0.1
* Initial release
