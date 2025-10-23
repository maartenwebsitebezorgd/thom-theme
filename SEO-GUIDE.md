# SEO & Performance Guide

This theme includes built-in SEO features and performance optimizations. Here's everything you need to know.

## 📊 SEO Features Included

### ✅ Automatic SEO Meta Tags

The theme automatically outputs SEO meta tags if you don't have an SEO plugin installed:

- **Meta Description** - Auto-generated from excerpt or content
- **Canonical URLs** - Prevents duplicate content issues
- **Open Graph Tags** - For Facebook sharing
- **Twitter Cards** - For Twitter sharing
- **Article Meta** - Published/modified dates for blog posts

**Location:** `app/Helpers/SEO.php`

### 🔌 SEO Plugin Compatibility

The built-in SEO features automatically disable if you install:
- Yoast SEO
- Rank Math
- All in One SEO (AIOSEO)

This prevents duplicate meta tags.

---

## 🎨 Favicons & Icons

### Required Files

Place these files in the `public/` directory:

```
public/
├── favicon.ico              (16x16 or 32x32)
├── favicon-16x16.png        (16x16 PNG)
├── favicon-32x32.png        (32x32 PNG)
├── apple-touch-icon.png     (180x180 PNG)
├── android-chrome-192x192.png (192x192 PNG)
├── android-chrome-512x512.png (512x512 PNG)
├── mstile-150x150.png       (150x150 PNG - for Windows)
├── site.webmanifest         (Already created - update with your info)
└── browserconfig.xml        (Already created)
```

### How to Generate Favicons

**Option 1: Use RealFaviconGenerator (Recommended)**
1. Go to https://realfavicongenerator.net/
2. Upload your logo (at least 512x512 PNG)
3. Download the generated package
4. Extract files to `public/` directory

**Option 2: Use Favicon.io**
1. Go to https://favicon.io/
2. Upload your image or generate from text/emoji
3. Download and extract to `public/` directory

**Option 3: Manual with design software**
- Create your logo at 512x512px
- Export at different sizes listed above
- Use PNG format for best quality

### Update Configuration

Edit `public/site.webmanifest`:
```json
{
  "name": "Your Full Site Name",
  "short_name": "Short Name",
  "description": "Your site description"
}
```

Edit the theme color in `resources/views/layouts/app.blade.php` line 18:
```html
<meta name="theme-color" content="#yourcolor">
```

---

## 🎯 ACF Fields for SEO (Optional)

You can add these ACF fields for better SEO control:

### Theme Options (ACF Options Page)

Create an ACF Options page called "SEO Settings" and add:

```php
// In your ACF field group
[
    'key' => 'field_seo_default_share_image',
    'label' => 'Default Share Image',
    'name' => 'default_share_image',
    'type' => 'image',
    'instructions' => 'Default image for social sharing (1200x630px recommended)',
    'return_format' => 'array',
],
[
    'key' => 'field_seo_twitter_handle',
    'label' => 'Twitter Handle',
    'name' => 'twitter_handle',
    'type' => 'text',
    'instructions' => 'Enter your Twitter username (without @)',
    'placeholder' => 'yourusername',
]
```

### Per-Page SEO (Optional)

Add to your page/post field groups:

```php
[
    'key' => 'field_meta_description',
    'label' => 'Meta Description',
    'name' => 'meta_description',
    'type' => 'textarea',
    'instructions' => 'Custom meta description (155 characters recommended)',
    'maxlength' => 160,
    'rows' => 3,
]
```

---

## 🚀 Performance Optimizations Included

### 1. **Clean WordPress Head**
Removes unnecessary code:
- WordPress version (security)
- Emoji scripts (not needed)
- XML-RPC (security)
- oEmbed discovery links
- Really Simple Discovery (RSD)
- Windows Live Writer manifest

### 2. **Security Headers**
Automatically adds:
- `X-Content-Type-Options: nosniff`
- `X-Frame-Options: SAMEORIGIN`
- `X-XSS-Protection: 1; mode=block`
- `Referrer-Policy: strict-origin-when-cross-origin`

### 3. **Resource Hints**
Preconnects to external resources for faster loading:
```html
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
```

Add more preconnects in `app/setup.php` line 328.

### 4. **Custom Image Sizes**
Pre-defined optimized image sizes:
- `thumbnail-large` - 800x600 (cropped)
- `hero` - 1920x1080 (cropped)
- `card` - 600x400 (cropped)

**Location:** `app/setup.php` lines 205-207

---

## 🔍 SEO Best Practices

### 1. **Use Proper Heading Hierarchy**
- Only one `<h1>` per page (automatically handled)
- Use `<h2>`, `<h3>`, etc. in order
- Don't skip heading levels

### 2. **Write Good Meta Descriptions**
- 120-155 characters
- Include target keywords naturally
- Make it compelling to encourage clicks
- Unique for each page

### 3. **Optimize Images**
- Use descriptive filenames (`blue-widget.jpg` not `IMG_1234.jpg`)
- Always add alt text
- Compress images before uploading
- Use modern formats (WebP) when possible

### 4. **Use Featured Images**
- Required for proper social sharing
- Recommended size: 1200x630px
- Should be relevant to content

### 5. **Create Good URLs**
In WordPress Settings → Permalinks:
- Use "Post name" structure
- Keep URLs short and descriptive
- Use hyphens (not underscores)

---

## 📱 Mobile Optimization

Already included:
```html
<meta name="viewport" content="width=device-width, initial-scale=1">
```

### Test Mobile Friendliness:
- Google Mobile-Friendly Test: https://search.google.com/test/mobile-friendly
- PageSpeed Insights: https://pagespeed.web.dev/

---

## 🔧 WordPress Theme Features

The theme supports:
- ✅ Custom logo (Appearance → Customize → Site Identity)
- ✅ Post thumbnails / Featured images
- ✅ Responsive embeds (YouTube, etc.)
- ✅ HTML5 markup
- ✅ Title tag management
- ✅ Automatic feed links (RSS)
- ✅ Wide/full width blocks in editor
- ✅ Editor styles
- ✅ Custom image sizes

---

## 🎯 Recommended SEO Plugins

While the theme has built-in SEO, you might want a plugin for:
- XML sitemaps
- Schema markup
- Advanced redirects
- SEO analysis tools

**Recommended:**
1. **Yoast SEO** (Free) - Most popular, great for beginners
2. **Rank Math** (Free) - More features, slightly more advanced
3. **All in One SEO** (Free/Premium) - Good middle ground

**Important:** Only install ONE SEO plugin!

---

## 📊 Tracking & Analytics

### Add Google Analytics

**Option 1: Via Plugin**
- Install "MonsterInsights" or "GA Google Analytics"

**Option 2: Manually (recommended)**
1. Get your Google Analytics tracking code
2. Add to `resources/views/layouts/app.blade.php` before `</head>`:

```blade
{{-- Google Analytics --}}
@production
<script async src="https://www.googletagmanager.com/gtag/js?id=G-XXXXXXXXXX"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());
  gtag('config', 'G-XXXXXXXXXX');
</script>
@endproduction
```

### Add Google Tag Manager

1. Get your GTM container code
2. Add to `resources/views/layouts/app.blade.php`:

```blade
{{-- After <head> tag --}}
@production
<!-- Google Tag Manager -->
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-XXXXXX');</script>
<!-- End Google Tag Manager -->
@endproduction

{{-- After <body> tag --}}
@production
<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-XXXXXX"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->
@endproduction
```

---

## ✅ SEO Checklist for Launch

Before going live:

- [ ] Install and configure an SEO plugin (or use built-in)
- [ ] Upload all favicon files to `public/` directory
- [ ] Set up Google Search Console
- [ ] Set up Google Analytics
- [ ] Create and submit XML sitemap
- [ ] Check all pages have unique titles and descriptions
- [ ] Add featured images to all posts
- [ ] Test site with Google Mobile-Friendly Test
- [ ] Test site with PageSpeed Insights
- [ ] Set up 301 redirects if migrating from old site
- [ ] Update `public/site.webmanifest` with your info
- [ ] Check robots.txt allows crawling
- [ ] Verify canonical URLs are correct
- [ ] Test social sharing (Facebook, Twitter)

---

## 🔗 Helpful Resources

- [Google Search Central](https://developers.google.com/search)
- [Yoast SEO Academy](https://yoast.com/academy/)
- [Moz Beginner's Guide to SEO](https://moz.com/beginners-guide-to-seo)
- [Google PageSpeed Insights](https://pagespeed.web.dev/)
- [RealFaviconGenerator](https://realfavicongenerator.net/)

---

## 🆘 Troubleshooting

**Meta tags not showing:**
- Make sure you don't have an SEO plugin AND the built-in SEO active
- Check page source (View → Developer → View Source)
- Clear cache (browser, WordPress, server)

**Favicons not showing:**
- Hard refresh browser (Cmd+Shift+R or Ctrl+Shift+R)
- Check files are in `public/` directory
- Clear browser cache
- Wait 24-48 hours for browsers to update

**Social sharing not working:**
- Test with [Facebook Debugger](https://developers.facebook.com/tools/debug/)
- Test with [Twitter Card Validator](https://cards-dev.twitter.com/validator)
- Make sure featured images are set (1200x630px recommended)
- Check Open Graph tags in page source

---

**Need help?** Check the main [README-DEPLOYMENT.md](README-DEPLOYMENT.md) or [DEPLOYMENT.md](DEPLOYMENT.md)
