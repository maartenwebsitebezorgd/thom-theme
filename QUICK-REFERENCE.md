## Documentation Index

| Topic | File |
|-------|------|
| 🚀 Deployment | [README-DEPLOYMENT.md](README-DEPLOYMENT.md) |
| 📊 SEO & Favicons | [SEO-GUIDE.md](SEO-GUIDE.md) |
| 🎨 Favicon Setup | [FAVICON-QUICK-START.md](FAVICON-QUICK-START.md) |
| ✅ What's New | [HEAD-IMPROVEMENTS.md](HEAD-IMPROVEMENTS.md) |
| 🔧 Full Deploy Guide | [DEPLOYMENT.md](DEPLOYMENT.md) |

### Add Favicons
1. Visit https://realfavicongenerator.net/
2. Upload logo (512x512 PNG)
3. Download package
4. Extract to `public/` directory
5. Update `public/site.webmanifest`

### Clear Cache
- SiteGround: Site Tools → Speed → Caching → Flush
- Browser: Cmd+Shift+R (Mac) or Ctrl+Shift+R (Windows)

### Test SEO
- Facebook: https://developers.facebook.com/tools/debug/
- Twitter: https://cards-dev.twitter.com/validator
- PageSpeed: https://pagespeed.web.dev/

## File Locations

```
Important Files:
├── app/setup.php              Theme configuration
├── app/Helpers/SEO.php        SEO functions
├── resources/views/
│   └── layouts/app.blade.php  Main layout (head section)
├── public/
│   ├── build/                 Compiled assets (deploy this!)
│   ├── favicon*.png           Your favicon files
│   └── site.webmanifest       PWA manifest
└── vite.config.js             Build configuration
```

## Pre-Launch Checklist

- [ ] Run `npm run build`
- [ ] Upload favicon files
- [ ] Update `site.webmanifest`
- [ ] Test on mobile
- [ ] Test social sharing
- [ ] Set up Google Analytics
- [ ] Set up Search Console
- [ ] Deploy to production
- [ ] Clear all caches

## Emergency Fixes

**Site broken after update?**
```bash
composer install
npm install
npm run build
# Upload public/build/ to server
```

**Blog showing Vite manifest error?**
```bash
npm run build
# Upload public/build/ folder
```

**Styles not loading?**
- Check `public/build/` uploaded
- Clear browser cache
- Clear SiteGround cache
- Hard refresh (Cmd+Shift+R)

## Support Links

- SiteGround Tools: Site Tools → Speed → Caching
- WordPress Admin: `/wp-admin`
- ACF Fields: WordPress Admin → Custom Fields

---

**Full documentation available in the files listed above** 👆
