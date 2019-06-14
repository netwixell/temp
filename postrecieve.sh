#!/bin/bash
MASTER_DIR="/home/molfarfo/molfarforum.com/www"
STAGE_DIR="/home/molfarfo/molfarforum.com/stage"
GIT_DIR="/home/molfarfo/repo/molfar.git"
BRANCH_MASTER="master"
BRANCH_STAGE="stage"

while read oldrev newrev ref
do
  # only checking out the master (or whatever branch you would like to deploy)
  if [[ $ref = refs/heads/$BRANCH_MASTER ]]
  then
    echo "Ref $ref received. Deploying ${BRANCH_MASTER} branch to production..."
    git --work-tree=$MASTER_DIR --git-dir=$GIT_DIR checkout -f
  elif [[ $ref = refs/heads/$BRANCH_STAGE ]]
  then
    echo "Ref $ref received. Deploying ${BRANCH_STAGE} branch to staging..."
    git --work-tree=$STAGE_DIR --git-dir=$GIT_DIR checkout -f
  else
    echo "Ref $ref received. Doing nothing: only the ${BRANCH} branch may be deployed on this server."
  fi
done
