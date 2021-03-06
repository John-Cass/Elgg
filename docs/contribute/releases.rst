Release Process Workflow
########################

Release a new version of Elgg.

This is the process the core team follows for making a new Elgg release.
We have published this information in the spirit of openness,
and to streamline onboarding of new team members.

.. contents:: Contents
   :local:
   :depth: 1

Requirements
============

* SSH access to elgg.org
* Commit access to http://github.com/Elgg/Elgg
* Admin access to https://elgg.org/
* Access to `Twitter account`_
* Access to `G+ page`_
* Node.js and NPM installed
* Sphinx installed (``easy_install sphinx && easy_install sphinx-intl``)
* Transifex client installed (``easy_install transifex-client``)
* Transifex account with access to Elgg project

1. First new stable minor/major release
=======================================

Make sure to update the :doc:`/appendix/support` document to include the new minor/major release date and fill in the blanks for the previous release. 

2. Prepare and tag the release
==============================

Make sure your local git clone is up to date!

Merge latest commits up from lowest supported branch.
Visit https://github.com/Elgg/Elgg/compare/new...old and submit the PR
if there is anything that needs to be merged up.

Install the prerequisites:

.. code:: sh

   npm install elgg-conventional-changelog
   easy_install sphinx
   easy_install sphinx-intl
   easy_install transifex-client

Run the ``release.php`` script. For example, to release 1.12.5:

.. code:: sh

   git checkout 1.12
   php .scripts/release.php 1.12.5

This creates a ``release-1.12.5`` branch in your local repo.

Next, manually browse to the ``/admin/settings/basic`` page and verify it loads. If it does not, a language file from Transifex may have a PHP syntax error. Fix the error and amend your commit with the new file:

.. code:: sh

    # only necessary if you fixed a language file
    git add .
    git commit --amend

Next, submit a PR via Github:

.. code:: sh

   git push your-remote-fork release-1.12.5

Once approved and merged, tag the release:

.. code:: sh

   git checkout release-${version}
   git tag -a ${version}
   git push origin ${release}

Update Milestones on Github
 * Mark release milestones as completed
 * Move unresolved tickets in released milestones to later milestones

3. Update the website
=====================

 * ssh to elgg.org
 * Clone https://github.com/Elgg/elgg-scripts

Build zip package for Elgg 1.n.n
--------------------------------

Use ``elgg-scripts/build/build.sh`` to generate the .zip file. Run without arguments to see usage.

Example::

    ./build.sh 1.12.5 1.12.5 /var/www/www.elgg.org/download/

MIT::

    ./build.sh 1.12.5 1.12.5-mit /var/www/www.elgg.org/download/

Build zip package for Elgg 2.n.n
--------------------------------

Use ``elgg-scripts/build/elgg-starter-project.sh`` to generate the .zip file. Run without arguments to see usage.

Example::

    ./elgg-starter-project.sh master 2.0.4 /var/www/www.elgg.org/download/

MIT::

    ./elgg-starter-project.sh master 2.0.4-mit /var/www/www.elgg.org/download/
    
	
Update elgg.org
---------------

* Clone https://github.com/Elgg/www.elgg.org
* Add the new versions to ``src/Elgg/Releases.php``
* Update vendors

  .. code:: sh

    composer update

* Commit and push the changes
* Pull to live site

  .. code:: sh

      cd /var/www/www.elgg.org && sudo su deploy && git pull
      
* Update dependencies

  .. code:: sh

     composer install --no-dev --prefer-dist --optimize-autoloader

* Go to community admin panel
    * Flush APC cache
    * Run upgrade

4. Make the announcement
========================

This should be the very last thing you do.

* Sign in at https://elgg.org/blog and compose a blog on with HTML version of CHANGELOG.md.
* Add tags “release” and “elgg1.x” where x is whatever branch is being released.
* Tweet from the elgg `Twitter account`_
* Post from the `G+ page`_

.. _G+ page: https://plus.google.com/+ElggOrg
.. _Twitter account: https://twitter.com/elgg

