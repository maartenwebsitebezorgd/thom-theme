# 🚀 Quick Deployment Guide

## For SiteGround Hosting

### 🎯 Fastest Way to Deploy

1. **Build assets locally:**
   ```bash
   npm run build
   ```

2. **Upload to server:**

   **Option A - Using the deploy script (SSH access required):**
   ```bash
   # First time: Edit deploy.sh with your SSH credentials
   # Then run:
   ./deploy.sh
   ```

   **Option B - Using FTP (FileZilla, etc):**
   - Upload the entire `public/build/` folder
   - Upload `vite.config.js`
   - Upload any changed PHP/Blade files

3. **Clear cache on SiteGround:**
   - Site Tools → Speed → Caching → Flush Cache

---

## 📁 Files You Must Upload After Building

Always upload these after running `npm run build`:

```
✅ public/build/              (entire folder - contains compiled CSS/JS)
✅ vite.config.js             (if you changed it)
✅ app/                        (if you changed PHP files)
✅ resources/views/            (if you changed Blade templates)
```

**Never upload:**
```
❌ node_modules/
❌ vendor/
❌ .env
```

---

## 🔄 Automated Deployment (Optional)

See [DEPLOYMENT.md](DEPLOYMENT.md) for:
- GitHub Actions setup (auto-deploy on push)
- Advanced deployment options
- Troubleshooting guide

---

## 🆘 Quick Fixes

**Blog showing error "Unable to locate file in Vite manifest":**
```bash
npm run build
# Upload public/build/ to server
```

**Changes not showing:**
1. Clear SiteGround cache (Site Tools → Speed → Caching)
2. Hard refresh browser (Cmd+Shift+R or Ctrl+Shift+R)

**Permission errors on server:**
```bash
# Via SSH:
chmod -R 755 /path/to/theme
```

---

## 📝 Quick Commands Reference

```bash
# Development
npm run dev          # Start local development server

# Production
npm run build        # Build for production (ALWAYS do this before deploying!)

# Deployment
./deploy.sh          # Deploy to server (after editing with SSH credentials)
```

---

## ✅ Pre-Deployment Checklist

Before each deployment:
- [ ] Run `npm run build`
- [ ] Test locally that build works
- [ ] Upload `public/build/` folder to server
- [ ] Clear server cache
- [ ] Test live site

---

**Need more help?** See [DEPLOYMENT.md](DEPLOYMENT.md) for detailed instructions.
