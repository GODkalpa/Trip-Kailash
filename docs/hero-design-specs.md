# Hero Video Widget - Design Specifications

## Overview
This document outlines the exact design specifications implemented for the Trip Kailash hero video section to match the provided screenshot.

## Layout Structure

```
┌─────────────────────────────────────────┐
│         [Trishul Icon - Gold]           │
│                                         │
│      Walk the Path of Gods              │
│                                         │
│  Experience sacred pilgrimages to the   │
│  most revered temples and holy sites    │
│                                         │
│  [Begin Your Yatra] [Speak with...]    │
│                                         │
│                                         │
│     DISCOVER SACRED JOURNEYS            │
│              ↓                          │
└─────────────────────────────────────────┘
```

## Typography

### Heading (H1)
- Font Family: Cinzel (serif heading font)
- Font Size: 42px - 64px (responsive clamp)
- Font Weight: 400 (regular)
- Color: White (#f5f2ed)
- Line Height: 1.2
- Letter Spacing: 1px
- Text Shadow: 0 2px 20px rgba(0, 0, 0, 0.5)
- Margin Bottom: 20px

### Subheading
- Font Family: Inter (sans-serif body font)
- Font Size: 16px - 19px (responsive clamp)
- Font Weight: 300 (light)
- Color: White with 92% opacity
- Line Height: 1.6
- Text Shadow: 0 1px 10px rgba(0, 0, 0, 0.4)
- Max Width: 800px
- Margin Bottom: 40px

### Scroll Text
- Font Family: Inter
- Font Size: 11px
- Font Weight: 600 (semi-bold)
- Letter Spacing: 2.5px
- Text Transform: Uppercase
- Color: White with 85% opacity
- Text Shadow: 0 1px 5px rgba(0, 0, 0, 0.4)

## Buttons

### Primary Button (Gold)
- Background: #b8860b (gold)
- Text Color: #2c2b28 (dark text)
- Border: 2px solid #b8860b
- Padding: 13px 32px
- Font Size: 15px
- Font Weight: 500
- Letter Spacing: 0.3px
- Border Radius: 4px
- Box Shadow: 0 2px 12px rgba(0, 0, 0, 0.25)

**Hover State:**
- Background: #c9a02c (lighter gold)
- Transform: translateY(-2px)
- Box Shadow: 0 4px 20px rgba(0, 0, 0, 0.35)

### Secondary Button (Outlined)
- Background: Transparent
- Text Color: White (#f5f2ed)
- Border: 2px solid rgba(245, 242, 237, 0.8)
- Padding: 11px 30px
- Font Size: 15px
- Font Weight: 500
- Letter Spacing: 0.3px
- Border Radius: 4px
- Box Shadow: 0 2px 12px rgba(0, 0, 0, 0.25)

**Hover State:**
- Background: rgba(245, 242, 237, 0.15)
- Border Color: #f5f2ed (solid white)
- Transform: translateY(-2px)
- Box Shadow: 0 4px 20px rgba(0, 0, 0, 0.35)

### Button Layout
- Display: Flex
- Gap: 16px
- Justify Content: Center
- Margin Bottom: 60px

## Icons

### Trishul Icon
- Width: 32px
- Height: 48px
- Color: Gold (#b8860b)
- Opacity: 85%
- Margin Bottom: 30px
- Filter: drop-shadow(0 2px 8px rgba(0, 0, 0, 0.3))
- Animation: Float (3s ease-in-out infinite, 8px vertical movement)

### Scroll Arrow
- Width: 20px
- Height: 20px
- Color: White
- Opacity: 85%
- Filter: drop-shadow(0 1px 3px rgba(0, 0, 0, 0.4))
- Animation: Bounce (2s ease-in-out infinite, 8px vertical movement)

## Spacing

- Trishul to Heading: 30px
- Heading to Subheading: 20px
- Subheading to Buttons: 40px
- Buttons to Bottom: 60px
- Scroll Indicator from Bottom: 50px
- Button Gap: 16px

## Video Background

### Video Element
- Position: Absolute, centered
- Min Width/Height: 100%
- Object Fit: Cover
- Z-Index: 1

### Overlay
- Background: Linear gradient from rgba(44, 43, 40, 0.4) to rgba(44, 43, 40, 0.6)
- Z-Index: 2
- Adjustable opacity via widget settings (default 40%)

### Sound Toggle Button
- Position: Absolute top-right (20px, 20px)
- Size: 50px × 50px
- Background: rgba(245, 242, 237, 0.9)
- Border Radius: 50% (circle)
- Z-Index: 3
- Box Shadow: 0 2px 10px rgba(0, 0, 0, 0.2)

## Responsive Breakpoints

### Tablet (max-width: 768px)
- Heading: Responsive clamp maintains readability
- Subheading: 16px fixed
- Buttons: Stack vertically, max-width 320px
- Trishul: 28px × 42px
- Scroll Text: 10px, letter-spacing 2px

### Mobile (max-width: 480px)
- Heading: Smaller clamp range
- Subheading: 15px
- Buttons: Slightly smaller padding
- Trishul: 24px × 36px
- Scroll Text: 9px, letter-spacing 1.8px
- Scroll Arrow: 16px × 16px

## Animations

### Float (Trishul)
```css
@keyframes tk-float {
  0%, 100% { transform: translateY(0); }
  50% { transform: translateY(-8px); }
}
```

### Bounce (Scroll Arrow)
```css
@keyframes tk-bounce {
  0%, 100% { transform: translateY(0); }
  50% { transform: translateY(8px); }
}
```

## Color Palette

- Gold: #b8860b
- Gold Hover: #c9a02c
- White: #f5f2ed
- Dark Text: #2c2b28
- Overlay: rgba(44, 43, 40, 0.4-0.6)

## Accessibility

- All interactive elements have focus states
- Sufficient color contrast for text readability
- Video muted by default (sound toggle available)
- Semantic HTML structure (h1, section, button)
- ARIA labels on interactive elements

## WordPress Integration

- Video uploaded via WordPress Media Library
- Supports MP4, WebM formats
- All text content editable via Elementor
- Overlay opacity adjustable (0-100%)
- Toggle options for trishul icon and scroll indicator
