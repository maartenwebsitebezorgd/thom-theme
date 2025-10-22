# Deployment Guide for SiteGround

This theme is built with Sage/Roots and uses Vite for asset compilation. Here are your deployment options:

## 📋 Prerequisites

Before deploying, always:
1. Run `npm run build` locally
2. Test the build works locally
3. Commit the built assets to git

---

## 🚀 Deployment Options

### Option 1: Simple Bash Script (Recommended for Quick Deploys)

The easiest way to deploy:

```bash
./deploy.sh
```

**First time setup:**
1. Edit `deploy.sh` and update:
   - `SSH_HOST` (your SiteGround SSH credentials)
   - `REMOTE_PATH` (path to theme on server)

2. Set up SSH key authentication (optional but recommended):
   ```bash
   # Generate SSH key if you don't have one
   ssh-keygen -t ed25519 -C "your_email@example.com"

   # Copy to SiteGround
   ssh-copy-id your-host@annejans100.sg-host.com
   ```

3. Run deployment:
   ```bash
   npm run build    # Build assets
   ./deploy.sh      # Deploy to server
   ```

---

### Option 2: GitHub Actions (Automated CI/CD)

Automatically deploy when you push to master/main branch.

**Setup:**

1. Get your SiteGround FTP credentials:
   - Go to SiteGround Site Tools → DevTools → FTP Accounts
   - Note: Server, Username, Password

2. Add secrets to GitHub repository:
   - Go to your GitHub repo → Settings → Secrets and variables → Actions
   - Add these secrets:
     - `FTP_SERVER` (e.g., `annejans100.sg-host.com`)
     - `FTP_USERNAME` (your FTP username)
     - `FTP_PASSWORD` (your FTP password)

3. Push your code:
   ```bash
   git add .
   git commit -m "Setup automated deployment"
   git push origin master
   ```

4. GitHub Actions will automatically:
   - Install dependencies
   - Build assets
   - Deploy to SiteGround

Check progress at: GitHub repo → Actions tab

---

### Option 3: Manual FTP Upload

If scripts don't work, use FTP manually:

1. **Build locally:**
   ```bash
   npm run build
   ```

2. **Upload via FileZilla or SiteGround File Manager:**
   - Connect to: `annejans100.sg-host.com`
   - Navigate to: `/public_html/wp-content/themes/thom/`
   - Upload these folders:
     - `public/build/` (entire folder)
     - `app/` (if PHP changed)
     - `resources/views/` (if templates changed)
     - `vite.config.js` (if changed)

---

### Option 4: SiteGround Git Integration (Advanced)

SiteGround offers Git deployment via SSH:

1. **SSH into SiteGround:**
   ```bash
   ssh your-host@annejans100.sg-host.com
   ```

2. **Navigate to theme:**
   ```bash
   cd /home/customer/www/annejans100.sg-host.com/public_html/wp-content/themes/thom
   ```

3. **Set up Git (first time only):**
   ```bash
   git init
   git remote add origin YOUR_GIT_REPO_URL
   ```

4. **Deploy updates:**
   ```bash
   git pull origin master
   ```

**Note:** You still need to build assets locally and commit them since Node.js may not be available on shared hosting.

---

## 📝 Deployment Checklist

Before each deployment:

- [ ] Run `npm run build` locally
- [ ] Test the site locally
- [ ] Commit changes to git (including `public/build/`)
- [ ] Run deployment script or push to GitHub
- [ ] Check the live site
- [ ] Clear server cache if needed (SiteGround Speed Optimizer)

---

## 🐛 Troubleshooting

### "Vite manifest error" on production

**Cause:** Built assets not uploaded or manifest.json missing

**Fix:**
```bash
npm run build
# Then upload public/build/ folder
```

### "Permission denied" errors

**Fix:**
```bash
# On server via SSH:
chmod -R 755 /path/to/theme
```

### Assets not loading (404 errors)

**Cause:** Wrong base path in vite.config.js

**Check:** vite.config.js line 7 matches your server structure:
```js
base: '/app/themes/thom/public/build/',
```

### Changes not showing up

**Fix:** Clear caches:
1. SiteGround Speed Optimizer cache
2. Browser cache (Cmd+Shift+R / Ctrl+Shift+R)
3. WordPress cache plugins

---

## 🔧 Quick Commands

```bash
# Build for production
npm run build

# Deploy (after setting up deploy.sh)
./deploy.sh

# Check what will be deployed
git status

# Commit built assets
git add public/build/ vite.config.js
git commit -m "Build assets"
git push
```

---

## 📚 Additional Resources

- [SiteGround SSH Tutorial](https://www.siteground.com/tutorials/ssh/)
- [Sage Documentation](https://roots.io/sage/docs/)
- [Vite Documentation](https://vitejs.dev/)
