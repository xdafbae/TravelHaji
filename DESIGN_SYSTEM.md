# Design System: Travel H&U

This document outlines the new design language for the Travel H&U application. The goal is to move away from generic "tech" aesthetics towards a warm, human-centric, and travel-oriented visual identity.

## 1. Core Philosophy
*   **Human & Organic**: Use warm tones, serif fonts, and soft shadows to evoke trust and comfort.
*   **Travel-Centric**: Colors inspired by nature (Earth, Ocean, Forest).
*   **Professional**: Clean typography and generous whitespace for readability.

## 2. Typography
We use a classic pairing of a Serif header and a Sans-serif body.

### Headings: **Playfair Display**
Used for page titles, card headers, and major emphasis.
*   Weights: 400 (Regular), 600 (Semi-bold), 700 (Bold)
*   Example: `<h1 class="font-serif font-bold text-2xl">Agency Overview</h1>`

### Body: **Lato**
Used for general text, navigation, tables, and buttons.
*   Weights: 300 (Light), 400 (Regular), 700 (Bold)
*   Example: `<p class="font-sans text-earth-700">Welcome back user.</p>`

## 3. Color Palette
Defined in `tailwind.config.js`.

### Brand (Ocean/Teal)
Primary action color, links, and active states.
*   **Primary**: `brand-600` (#0284c7)
*   **Dark**: `brand-800` (#075985)
*   **Light**: `brand-50` (#f0f9ff)

### Nature (Forest Green)
Success states, growth indicators, and eco-friendly accents.
*   **Primary**: `nature-600` (#239962)
*   **Bg**: `nature-100` (#e1f9e8)

### Earth (Warm Neutrals)
Backgrounds, borders, and text.
*   **Background**: `earth-50` (#fbf8f6) - "Paper" white.
*   **Surface**: `white` (#ffffff)
*   **Text Main**: `earth-900` (#543d34)
*   **Text Muted**: `earth-500` (#b0846a)
*   **Border**: `earth-200` (#e9dfd6)

## 4. Components

### Cards
Cards are the primary container for content. They should feel like physical cards on a table.
*   **Background**: White
*   **Border**: `border border-earth-100` (Subtle definition)
*   **Shadow**: `shadow-soft` (Diffused, non-intrusive)
*   **Radius**: `rounded-2xl` (Soft corners)

```html
<div class="bg-white shadow-soft rounded-2xl p-6 border border-earth-100">
    ...content
</div>
```

### Buttons
Buttons should be clear and tactile.
*   **Primary**: `bg-brand-700 text-white hover:bg-brand-800 rounded-xl`
*   **Secondary**: `bg-white border border-earth-300 text-earth-700 hover:bg-earth-50 rounded-xl`

### Sidebar
Moved to a light theme to reduce visual weight.
*   **Bg**: White
*   **Active Link**: `bg-earth-100 text-brand-700 font-semibold`
*   **Inactive Link**: `text-earth-700 hover:text-brand-700`

## 5. Spacing & Grid
*   **Base Unit**: 4px (Tailwind standard).
*   **Container Padding**: `p-6` or `p-8` for main content areas to allow breathing room.
*   **Gap**: `gap-6` or `gap-8` between cards.

## 6. Implementation Notes
*   **Tailwind Config**: Colors and fonts are extended in `theme.extend`.
*   **Icons**: FontAwesome is used, but styled with brand colors (not default black/blue).
*   **Charts**: Chart.js colors must be manually synchronized with the hex codes above.
