# Image Focal Point Implementation Guide

## Overview

This document outlines how to implement focal point control for images that use `object-cover` in the theme. This allows editors to control where images are anchored when they're cropped to fit their containers.

**Status:** Research Complete - Not Yet Implemented
**Complexity:** Moderate (2-6 hours depending on approach)
**Priority:** Nice to have / Future enhancement

---

## Current Situation

Images currently use `object-cover` with default center positioning. When images are cropped to fit aspect ratios, they always center on the middle of the image, which can cut off important parts (like faces in portraits).

### Files Using `object-cover` (8 total)

**Centralized (Visual Component):**
1. `resources/views/components/visual.blade.php` - Used by split_content, stacked_content, etc.

**Standalone Images:**
2. `resources/views/partials/content-team.blade.php` - Team member headshots (3 locations)
3. `resources/views/components/team-horizontal-card.blade.php` - Small circular avatars
4. `resources/views/flexible/split_form.blade.php` - Contact person headshot
5. `resources/views/flexible/team_contact_cta.blade.php` - CTA team member image
6. `resources/views/flexible/quote.blade.php` - Quote author image
7. `resources/views/components/background.blade.php` - Background videos (optional)

---

## Implementation Approaches

### Approach 1: Pure CSS (Recommended)

**Pros:**
- No plugin dependencies
- Leverages existing Tailwind utilities
- Consistent with current architecture
- Easy to implement and maintain
- Fast implementation (2-4 hours)

**Cons:**
- No visual focal point picker (dropdown selection only)
- 9 preset positions only (unless using arbitrary values)

**Best for:** Quick implementation, maintaining lightweight codebase

### Approach 2: Plugin-Based Visual Picker

**Pros:**
- Visual interface - click on image to set focal point
- Precise x/y percentage coordinates
- Better UX for content editors

**Cons:**
- Requires plugin installation and maintenance
- Additional dependency
- More complex implementation (4-6 hours)
- Plugin compatibility risk with future WordPress/ACF updates

**Available Plugins:**
- [ACF: Focal Point](https://github.com/jhealey5/acf-focal_point) by jhealey5
- [ACF: FocusPoint](https://github.com/ooksanen/acf-focuspoint) by ooksanen
- [ACF Focal Field](https://web321.co/our-plugins/acf-focal-field/) by Web321

**Best for:** Sites where precise focal point control is critical

---

## Recommended Implementation: Pure CSS Approach

### Phase 1: Visual Component (80% Coverage)

This covers split_content, stacked_content, and any other section using the Visual component.

#### Step 1: Add Position Choices to Helpers

**File:** `app/Fields/Helpers/Choices.php`

Add this method after the existing methods:

```php
public static function objectPosition()
{
    return [
        'object-center' => 'Center (Default)',
        'object-top' => 'Top',
        'object-top-right' => 'Top Right',
        'object-right' => 'Right',
        'object-bottom-right' => 'Bottom Right',
        'object-bottom' => 'Bottom',
        'object-bottom-left' => 'Bottom Left',
        'object-left' => 'Left',
        'object-top-left' => 'Top Left',
    ];
}
```

**Estimated time:** 5 minutes

#### Step 2: Add ACF Field to Visual Component

**File:** `app/Fields/Components/Visual.php`

Add this field after the `object_fit` field (after line 69):

```php
->addSelect('object_position', [
    'label' => 'Focal Point Position',
    'instructions' => 'Control where the image is anchored when cropped (only applies when Object Fit is set to Cover)',
    'choices' => Choices::objectPosition(),
    'default_value' => $defaults['object_position'] ?? 'object-center',
    'conditional_logic' => [
        [
            [
                'field' => 'object_fit',
                'operator' => '==',
                'value' => 'object-cover',
            ],
        ],
    ],
    'wrapper' => ['width' => '50'],
])
```

**Estimated time:** 10 minutes

#### Step 3: Update Visual Blade Component

**File:** `resources/views/components/visual.blade.php`

**Change 1:** Add to props (around line 6):
```php
@props([
    'visual' => [],
    'objectFit' => null,
    'objectPosition' => null, // ADD THIS LINE
    'borderRadius' => null,
    // ... rest of props
])
```

**Change 2:** Extract setting (around line 24):
```php
// Get visual settings
$objectFit = $objectFit ?? $visual['object_fit'] ?? 'object-cover';
$objectPosition = $objectPosition ?? $visual['object_position'] ?? 'object-center'; // ADD THIS LINE
$borderRadius = $borderRadius ?? $visual['border_radius'] ?? 'rounded-none';
```

**Change 3:** Add to media classes (around line 93):
```php
$mediaClasses = [
    'w-full',
    'h-full',
    $objectFit,
    $objectFit === 'object-cover' ? $objectPosition : '', // ADD THIS LINE
    $opacity < 100 ? 'opacity-' . $opacity : '',
];
```

**Estimated time:** 15 minutes

**Total Phase 1 Time:** ~30 minutes

---

### Phase 2: Standalone Images (Optional)

Evaluate if needed based on real-world usage. Most important candidates:

#### Priority 1: Team Member Cards
**File:** `resources/views/partials/content-team.blade.php`

Add focal point field to Team post type ACF fields, then update template.

#### Priority 2: Quote Author Images
**File:** `resources/views/flexible/quote.blade.php`

Add to Quote section ACF fields.

#### Priority 3: Split Form Contact Person
**File:** `resources/views/flexible/split_form.blade.php`

Already pulls from Team post type, so would be covered by Priority 1.

**Estimated time per file:** 30-60 minutes

---

## Testing Checklist

After implementation, test:

- [ ] Visual component in Split Content section
- [ ] Visual component in Stacked Content section
- [ ] All 9 position options render correctly
- [ ] Conditional logic hides field when object-fit is not "cover"
- [ ] Default position is "center" for existing content
- [ ] Responsive behavior (positions work at all breakpoints)
- [ ] Team member images (if Phase 2 implemented)
- [ ] Quote author images (if Phase 2 implemented)

---

## Tailwind CSS Object Position Reference

**Available Utility Classes:**

| Class | CSS Output | Description |
|-------|-----------|-------------|
| `object-center` | `object-position: center` | Centers image (default) |
| `object-top` | `object-position: top` | Anchors to top center |
| `object-top-right` | `object-position: top right` | Anchors to top-right corner |
| `object-right` | `object-position: right` | Anchors to middle-right |
| `object-bottom-right` | `object-position: bottom right` | Anchors to bottom-right |
| `object-bottom` | `object-position: bottom` | Anchors to bottom center |
| `object-bottom-left` | `object-position: bottom left` | Anchors to bottom-left |
| `object-left` | `object-position: left` | Anchors to middle-left |
| `object-top-left` | `object-position: top left` | Anchors to top-left corner |

**Custom Values:**
For precise control, you can use arbitrary values:
```html
<img class="object-cover object-[25%_75%]" />
```

**Responsive:**
```html
<img class="object-center md:object-top lg:object-right" />
```

---

## Use Cases

### When Focal Point Control is Useful:

1. **Portrait Photos in Landscape Containers**
   - Problem: Faces get cropped out when centered
   - Solution: Use `object-top` to keep faces visible

2. **Team Member Headshots**
   - Problem: Heads cut off in square aspect ratios
   - Solution: Use `object-top` or `object-top-left`

3. **Product Images with Text**
   - Problem: Important text on image gets cropped
   - Solution: Position to keep text visible

4. **Architectural/Landscape Photos**
   - Problem: Interesting features are off-center
   - Solution: Position to feature the main subject

### When Default Center is Fine:

1. Symmetrical subjects
2. Abstract backgrounds
3. Patterns and textures
4. Already centered compositions

---

## Alternative: Plugin Implementation

If you decide to go with a visual focal point picker plugin instead:

### Installation Steps

1. **Install Plugin:**
   ```bash
   # Using Composer (if plugin is available)
   composer require [plugin-name]

   # Or install via WordPress admin:
   # Plugins > Add New > Upload Plugin
   ```

2. **Activate Plugin:**
   ```bash
   wp plugin activate acf-focal-point
   ```

3. **Add Focal Point Field:**
   - Go to ACF Field Groups
   - Add new "Focal Point" field type to image fields
   - Returns array: `['x' => 50, 'y' => 50]` (percentages)

4. **Update Templates:**
   ```php
   @php
   $focalPoint = $image['focal_point'] ?? ['x' => 50, 'y' => 50];
   $objectPosition = $focalPoint['x'] . '% ' . $focalPoint['y'] . '%';
   @endphp

   <img
       src="{{ $image['url'] }}"
       class="object-cover"
       style="object-position: {{ $objectPosition }}"
   />
   ```

---

## Resources

### Documentation
- [Tailwind CSS Object Position](https://tailwindcss.com/docs/object-position)
- [MDN: object-position](https://developer.mozilla.org/en-US/docs/Web/CSS/object-position)
- [CSS Tricks: object-fit and object-position](https://css-tricks.com/almanac/properties/o/object-position/)

### Plugins
- [ACF: Focal Point on GitHub](https://github.com/jhealey5/acf-focal_point)
- [ACF: FocusPoint on GitHub](https://github.com/ooksanen/acf-focuspoint)

### Related Tailwind Utilities
- [Object Fit](https://tailwindcss.com/docs/object-fit) - Already implemented in Visual component
- [Aspect Ratio](https://tailwindcss.com/docs/aspect-ratio) - Already implemented

---

## Decision: Which Approach to Use?

### Choose Pure CSS if:
- You want quick implementation
- 9 preset positions are sufficient
- You prefer zero dependencies
- You want to maintain a lightweight codebase

### Choose Plugin if:
- Editors need precise control over focal points
- Visual interface is important for UX
- You're okay with maintaining another plugin
- Budget allows for additional implementation time

---

## Questions Before Implementation

Consider these questions:

1. **How often will editors actually need focal point control?**
   - If rarely, presets are fine
   - If frequently, visual picker is better

2. **What's the most common use case?**
   - Team photos → Simple presets work great
   - Product photos → May need precise control

3. **Who are the content editors?**
   - Technical users → Dropdown is fine
   - Non-technical → Visual picker is friendlier

4. **What's the maintenance budget?**
   - Limited → Stick with pure CSS
   - Flexible → Plugin is okay

---

## Implementation Timeline

### Quick Win (30 minutes)
- Phase 1 only: Visual component with 9 preset positions
- Covers 80% of use cases immediately

### Complete Implementation (2-4 hours)
- Phase 1: Visual component
- Phase 2: Team member cards
- Phase 2: Quote author images
- Testing across all sections

### Plugin Route (4-6 hours)
- Plugin research and selection
- Plugin installation and configuration
- Template updates across all files
- Coordinate calculation logic
- Comprehensive testing

---

## Next Steps

When ready to implement:

1. Decide on approach (Pure CSS vs Plugin)
2. If Pure CSS:
   - Start with Phase 1 (Visual component)
   - Test on staging
   - Evaluate need for Phase 2
3. If Plugin:
   - Select specific plugin
   - Install on staging first
   - Test thoroughly before production

---

**Last Updated:** December 2024
**Status:** Research complete, awaiting implementation decision
