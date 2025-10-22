#!/bin/bash

# Deployment script for SiteGround
# This script builds assets locally and syncs to the server

set -e

echo "🚀 Starting deployment..."

# Colors for output
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
NC='\033[0m' # No Color

# Configuration (update these)
SSH_HOST="your-host@annejans100.sg-host.com"
REMOTE_PATH="/home/customer/www/annejans100.sg-host.com/public_html/wp-content/themes/thom"

# Step 1: Build assets
echo -e "${YELLOW}📦 Building assets...${NC}"
npm run build

# Step 2: Commit built assets if needed
echo -e "${YELLOW}💾 Checking for changes...${NC}"
if [[ -n $(git status -s public/build/) ]]; then
    echo "Changes detected in build files"
    git add public/build/ vite.config.js
    git status --short

    read -p "Commit these changes? (y/n) " -n 1 -r
    echo
    if [[ $REPLY =~ ^[Yy]$ ]]; then
        git commit -m "Build assets for deployment"
        echo -e "${GREEN}✅ Changes committed${NC}"
    fi
else
    echo "No changes in build files"
fi

# Step 3: Sync files to server
echo -e "${YELLOW}📤 Syncing files to server...${NC}"

# Option A: Using rsync (recommended)
rsync -avz --delete \
    --exclude='.git' \
    --exclude='node_modules' \
    --exclude='.env' \
    --exclude='tests' \
    --exclude='.DS_Store' \
    --exclude='*.log' \
    ./ "${SSH_HOST}:${REMOTE_PATH}/"

# Option B: Using SCP (alternative)
# scp -r ./public/build "${SSH_HOST}:${REMOTE_PATH}/public/"
# scp -r ./app "${SSH_HOST}:${REMOTE_PATH}/"
# scp -r ./resources/views "${SSH_HOST}:${REMOTE_PATH}/resources/"

echo -e "${GREEN}✅ Deployment complete!${NC}"
echo "🌐 Visit: https://annejans100.sg-host.com"
