# Newbie Guide to Contributing

At ChassisPHP we want the community to be welcoming to all. We want to make contributing fun, easy, and educational. This guide is meant to be as simple and helpful as possible. If you run into difficulties when following this guide, PLEASE submit an issue. 

## Setting up for the first time
{assumptions: 1)you have a GitHub Account, 2)you have Git installed on your local computer, 3)you have Composer installed on your local computer}
1. Fork the repo 
   This is done on Github. Forking puts a copy of the repo in your GitHub account
   
2. Clone the repo
   This process takes a copy of the repo and puts it on your local computer
   `cd /path/to/directory/` (this should be the directory where the directory that contains the ChassisPHP project will be placed)
   `git clone https://github.com/RogerCreasy/ChassisPHP.git`
3. Copy .env.example to .env
   cd to ChassisPHP project directory
   `cp .env.example`
4. Install PHP dependencies
   `composer install`
    
## Git Workflow
1. Make sure you have all recent changes to ChassisPHP
   `git fetch origin`
2. Create a branch to work on your changes
   `git checkout -b issue[number]` where [number] is the issue number that you are working on.
   i.e. `git checkout -b issue315`
3. Make your code changes
4. Commit your changes
   `git add .`
   `git commit -m "commit message"` commit messages should be concise, and in the present tense
5. Push your changes to GitHub
   `git push origin issue[number]`
6. Repeat steps 2-5 until your changes are complete
7. Update your local master branch
   `git checkout master`
   `git pull master`
8. Rebase your branch on top of the now-current master branch
   `git checkout issue[number]`
   `git rebase issue[number] master`
   Fix any conflicts
9. Push your final changes to the repo on GitHub
   `git push issue[number] --force` Never force to a common branch (any branch that others work on). Only on your issue branch!
10. Submit a PR (Pull Request)
    a. On GitHub, on the ChassisPHP page, click on the "Pull Requests" tab
    b. Click on the green "New Pull Request" button
    c. Choose your branch as the branch to be merged
    d. Explain your PR
    
You may be asked questions, or to make changes to your code. Don't take offense; you didn't do anything wrong. These questions or changes are likely only to make your code better match the ChassisPHP project. Also, in the event there have been other changes to the master branch, you may be asked to rebase again. This is necessary to assure your branch has all of the most-recent changes.

Thanks for considering contributing! We hope to see your code in the ChassisPHP project!
   
   

   
