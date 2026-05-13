# Design System Inspired by shadcn/ui

## 1. Visual Theme & Atmosphere

The shadcn/ui design system embodies a clean, minimalist aesthetic rooted in modern web development practices. It prioritizes clarity, accessibility, and developer-friendly implementation while maintaining visual elegance through generous whitespace, subtle borders, and a refined neutral palette. The system balances functional simplicity with sophisticated detailing—using soft shadows, carefully calibrated spacing, and intuitive component hierarchies. The overall mood is professional yet approachable, suitable for developer-focused tools, configuration interfaces, and applications requiring both technical credibility and user-friendly interaction patterns.

**Key Characteristics**
- Minimalist aesthetic with emphasis on clarity and function
- Soft, subtle shadows and refined depth treatment
- Open-source philosophy reflected in transparent, customizable design
- Developer-centric component patterns with semantic naming
- High contrast typography for readability
- Generous whitespace and breathing room
- Neutral-first color strategy with selective accent use
- Responsive and accessible component primitives

## 2. Color Palette & Roles

### Primary
- **Primary Action** (`#000000`): Dark/black for primary interactive elements, CTAs, and dominant text
- **Primary Light** (`#FFFFFF`): Pure white for primary backgrounds and high-contrast text

### Accent Colors
- **Accent Blue** (`#1447E6`): Secondary highlight color for links, focus states, and selective emphasis
- **Accent Red** (`#FF6568`): Subtle accent for secondary highlights or tertiary interactions

### Interactive
- **Interactive Dark** (`#000000`): Button backgrounds for primary CTAs, active states
- **Interactive Ghost** (`rgba(0, 0, 0, 0)`): Transparent backgrounds for ghost/text buttons

### Neutral Scale
- **Neutral 900** (`#0A0A0A`): Darkest neutral, near-black for deep contrast
- **Neutral 800** (`#171717`): Very dark gray for subtle text hierarchy
- **Neutral 500** (`#A1A1A1`): Mid-tone gray for secondary text and placeholders
- **Neutral 100** (`#F5F5F5`): Light gray for subtle backgrounds
- **Neutral 50** (`#FAFAFA`): Very light neutral for soft backgrounds

### Surface & Borders
- **Surface Primary** (`#FFFFFF`): Main content surfaces and cards
- **Surface Secondary** (`#FAFAFA`): Alternate surface for subtle distinction
- **Border Light** (`#E5E5E5`): Standard border color for inputs, cards, and dividers

### Semantic / Status
- **Error/Danger** (`#E40014`): Critical error states and destructive actions
- **Error Secondary** (`#DF2225`): Secondary error indication

## 3. Typography Rules

### Font Family
- **Primary Font**: Geist, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif
- **Fallback Stack**: -apple-system, BlinkMacSystemFont, "Segoe UI", "Roboto", "Oxygen", "Ubuntu", "Cantarell", "Fira Sans", "Droid Sans", "Helvetica Neue", sans-serif

### Hierarchy

| Role | Font | Size | Weight | Line Height | Letter Spacing | Notes |
|------|------|------|--------|-------------|----------------|-------|
| **Display/H1** | Geist | 48px | 600 | 52.8px | 0px | Hero headings, page titles |
| **Heading 2** | Geist | 32px | 600 | 38.4px | 0px | Section headers, major headings |
| **Heading 3** | Geist | 24px | 600 | 28.8px | 0px | Subsection headers, card titles |
| **Body** | Geist | 18px | 400 | 28px | 0px | Primary body text, descriptions |
| **Body Small** | Geist | 16px | 400 | 24px | 0px | Secondary body text |
| **Label/Span** | Geist | 14px | 500 | 20px | 0px | Form labels, buttons, badges |
| **Caption** | Geist | 12px | 400 | 18px | 0px | Helper text, timestamps, metadata |
| **Code** | Geist Mono | 14px | 400 | 20px | 0px | Code blocks, technical text |
| **Input** | Geist | 14px | 400 | 20px | 0px | Form input text |

### Principles
- **Typographic Hierarchy**: Rely on weight (600 for emphasis, 400 for body) and size changes rather than excessive color variation
- **Line Length**: Optimal reading width around 65–75 characters; longer lines use increased line-height
- **Readability First**: High contrast between text and background; minimum 14px for body text
- **Consistency**: Use Geist across all UI for unified brand voice; monospace reserved for code contexts only
- **Semantic Naming**: Typography roles map directly to component intent (labels, body, captions)

## 4. Component Stylings

### Buttons

**Primary Button**
- Background: `#000000`
- Text Color: `#FFFFFF`
- Font Size: `14px`
- Font Weight: `500`
- Padding: `10px 16px`
- Border Radius: `8px`
- Border: `1px solid transparent`
- Height: `32px`
- Line Height: `20px`
- Hover: Background `#171717`, cursor pointer
- Active: Background `#0A0A0A`
- Focus: Ring `2px solid #1447E6` offset `2px`

**Secondary Button**
- Background: `#FFFFFF`
- Text Color: `#000000`
- Font Size: `14px`
- Font Weight: `500`
- Padding: `10px 16px`
- Border Radius: `8px`
- Border: `1px solid #E5E5E5`
- Height: `32px`
- Line Height: `20px`
- Hover: Background `#FAFAFA`, border `#D3D3D3`
- Active: Background `#F5F5F5`
- Focus: Ring `2px solid #1447E6` offset `2px`

**Ghost Button**
- Background: `transparent`
- Text Color: `#000000`
- Font Size: `14px`
- Font Weight: `500`
- Padding: `8px 8px`
- Border Radius: `8px`
- Border: `0px solid transparent`
- Height: `32px`
- Line Height: `20px`
- Hover: Background `#F5F5F5`
- Active: Background `#E5E5E5`
- Focus: Ring `2px solid #1447E6` offset `2px`

### Cards & Containers

**Card Default**
- Background: `#FFFFFF`
- Text Color: `#000000`
- Padding: `16px`
- Border Radius: `14px`
- Border: `1px solid #E5E5E5`
- Box Shadow: `0px 1px 3px rgba(0, 0, 0, 0.1)`
- Min Height: `auto`
- Hover: Border color `#D3D3D3`

**Card Elevated**
- Background: `#FFFFFF`
- Text Color: `#000000`
- Padding: `24px`
- Border Radius: `14px`
- Border: `1px solid #E5E5E5`
- Box Shadow: `0px 4px 12px rgba(0, 0, 0, 0.08)`

**Container**
- Background: `#FAFAFA`
- Text Color: `#000000`
- Padding: `16px`
- Border Radius: `10px`
- Border: `0px`
- Margin Bottom: `16px`

### Inputs & Forms

**Text Input**
- Background: `#FFFFFF`
- Text Color: `#000000`
- Font Size: `14px`
- Font Weight: `400`
- Padding: `8px 12px`
- Border Radius: `8px`
- Border: `1px solid #E5E5E5`
- Height: `36px`
- Line Height: `20px`
- Placeholder Color: `#A1A1A1`
- Focus: Border `#1447E6`, ring `2px solid rgba(20, 71, 230, 0.1)`
- Hover: Border `#D3D3D3`

**Select/Dropdown**
- Background: `#FFFFFF`
- Text Color: `#000000`
- Font Size: `14px`
- Padding: `8px 12px`
- Border Radius: `8px`
- Border: `1px solid #E5E5E5`
- Height: `36px`
- Hover: Border `#D3D3D3`
- Focus: Border `#1447E6`, ring `2px solid rgba(20, 71, 230, 0.1)`

**Checkbox**
- Size: `16px × 16px`
- Border: `2px solid #E5E5E5`
- Border Radius: `4px`
- Background Unchecked: `#FFFFFF`
- Background Checked: `#000000`
- Checkmark Color: `#FFFFFF`
- Focus: Ring `2px solid rgba(20, 71, 230, 0.1)`

**Form Label**
- Font Size: `14px`
- Font Weight: `500`
- Color: `#000000`
- Margin Bottom: `8px`
- Line Height: `20px`

### Navigation

**Nav Link**
- Text Color: `#000000`
- Font Size: `14px`
- Font Weight: `500`
- Padding: `8px 12px`
- Border Radius: `6px`
- Background: `transparent`
- Hover: Background `#F5F5F5`
- Active: Background `#E5E5E5`, color `#000000`
- Focus: Ring `2px solid #1447E6` offset `2px`

**Top Navigation**
- Background: `#FFFFFF`
- Height: `56px`
- Padding: `0px 24px`
- Border Bottom: `1px solid #E5E5E5`
- Display: `flex`
- Align Items: `center`
- Gap: `24px`

### Badges

**Badge Default**
- Background: `#000000`
- Text Color: `#FFFFFF`
- Font Size: `12px`
- Font Weight: `500`
- Padding: `4px 12px`
- Border Radius: `12px`
- Height: `24px`
- Line Height: `16px`

**Badge Secondary**
- Background: `#F5F5F5`
- Text Color: `#000000`
- Font Size: `12px`
- Font Weight: `500`
- Padding: `4px 12px`
- Border Radius: `12px`
- Border: `1px solid #E5E5E5`

**Badge Status**
- Background: `#E40014` (error), `#22C55E` (success)
- Text Color: `#FFFFFF`
- Font Size: `12px`
- Font Weight: `500`
- Padding: `4px 12px`
- Border Radius: `12px`

## 5. Layout Principles

### Spacing System

**Base Unit**: `4px`

**Spacing Scale**:
- `4px` — Tight spacing within components, icon gaps
- `8px` — Small gaps between elements, compact spacing
- `12px` — Standard margin within components
- `16px` — Component padding, section spacing
- `20px` — Medium gap between section groups
- `24px` — Card padding, vertical section spacing
- `32px` — Large section spacing
- `40px` — Extra-large spacing for major sections
- `80px` — Hero/page-level spacing

**Usage Context**:
- Micro spacing (4px–8px): Icon-to-text, inline element gaps
- Component spacing (12px–16px): Internal padding, between form fields
- Section spacing (20px–40px): Between major content blocks
- Page spacing (40px–80px): Hero sections, section dividers

### Grid & Container

- **Max Width**: `1280px` (lg), `1024px` (md), `768px` (sm), `480px` (xs)
- **Column Strategy**: Flexible 12-column grid; components use responsive widths
- **Container Padding**: `16px` on mobile, `24px` on tablet, `32px` on desktop
- **Gutter**: `16px` between columns on all breakpoints
- **Section Patterns**: Full-width hero, constrained content, grid-based layouts for dashboard/form interfaces

### Whitespace Philosophy

Whitespace is treated as a design element, not wasted space. The system uses deliberate breathing room around text, between sections, and within components to enhance legibility and focus. Negative space improves cognitive load and visual hierarchy. Compact spacing is reserved for related items; larger gaps separate distinct content regions.

### Border Radius Scale

- `4px` — Input fields, small buttons, minimal rounding
- `6px` — Nav links, small interactive elements
- `8px` — Standard buttons, smaller containers
- `10px` — Form inputs, medium containers
- `12px` — Badges, rounded accent elements
- `14px` — Cards, larger containers
- `16px` — Large modals, expanded containers
- `9996px` — Fully rounded buttons (pill-shaped CTAs)

## 6. Depth & Elevation

| Level | Treatment | Use |
|-------|-----------|-----|
| **Flat** | No shadow, `box-shadow: none` | Ghost buttons, text-only links, flat backgrounds |
| **Raised (sm)** | `0px 1px 2px rgba(0, 0, 0, 0.05)` | Input fields, secondary surfaces |
| **Raised (md)** | `0px 4px 6px rgba(0, 0, 0, 0.07), 0px 1px 3px rgba(0, 0, 0, 0.06)` | Cards at rest, standard containers |
| **Elevated (lg)** | `0px 10px 15px rgba(0, 0, 0, 0.1), 0px 4px 6px rgba(0, 0, 0, 0.05)` | Modals, floating panels, dropdowns |
| **Hover Lift** | `0px 6px 12px rgba(0, 0, 0, 0.12)` | Card hover states, interactive surfaces |

**Shadow Philosophy**

The system uses subtle, layered shadows to create gentle depth without visual heaviness. Shadows are soft and diffused, rarely pure black—using `rgba(0, 0, 0, 0.05–0.12)` for authenticity. Only elevated components (modals, dropdowns) receive stronger shadows. Most interactive surfaces remain flat or use minimal shadows, maintaining a clean, modern appearance while preserving visual hierarchy through border colors and background subtlety.

## 7. Do's and Don'ts

### Do
- **Use black (`#000000`) for primary CTAs and dominant UI elements** — establishes clear interaction hierarchy
- **Combine weight and size for typography hierarchy** — avoid relying solely on color to differentiate text roles
- **Apply subtle borders (`#E5E5E5`) to define input and card boundaries** — aids visual clarity on light backgrounds
- **Leverage generous padding (16px–24px) within containers** — enhances scanability and reduces cognitive load
- **Use the neutral scale for secondary text** — `#A1A1A1` for placeholders, `#171717` for secondary labels
- **Maintain 32px minimum touch targets for buttons and interactive elements** — ensures accessibility
- **Apply focus rings (2px `#1447E6`) consistently to all focusable elements** — critical for keyboard navigation
- **Keep border radii consistent within logical groups** — 8px for buttons, 10px for inputs, 14px for cards
- **Use `rgba(0, 0, 0, 0.05–0.12)` for subtle shadows on elevation** — maintains refined aesthetic

### Don't
- **Don't use color alone to communicate status** — pair with icons, text, or position changes
- **Don't apply heavy shadows or blur effects** — shadows should be subtle, supporting hierarchy without distraction
- **Don't mix font families across core UI** — maintain Geist for consistency; use monospace only for code blocks
- **Don't set text smaller than 14px for body or interactive content** — compromises readability
- **Don't use all caps for body text** — reserved for labels, badges, and selective emphasis
- **Don't forget padding in compact components** — cramped spacing reduces usability
- **Don't skip focus states for accessibility** — every interactive element requires clear focus indication
- **Don't violate the 4px spacing base unit** — breaks alignment and rhythm
- **Don't use high-saturation colors for primary elements** — the neutral-first palette supports professional credibility

## 8. Responsive Behavior

### Breakpoints

| Breakpoint | Width | Key Changes |
|------------|-------|-------------|
| **xs** | 320px | Single column, full padding (`16px`), stacked buttons |
| **sm** | 480px | Single column, layout adjustments, compressed spacing |
| **md** | 768px | Two-column for grids, container padding (`24px`), nav adjustments |
| **lg** | 1024px | Three-column layouts, increased spacing, sidebar patterns |
| **xl** | 1280px | Multi-column layouts, max-width containers, expanded whitespace |

### Touch Targets

- **Minimum Interactive Size**: `32px × 32px` (buttons, links, checkboxes)
- **Recommended Padding**: `8px` minimum around tap targets
- **Spacing Between Touch Targets**: `8px` minimum vertical/horizontal gap
- **Form Elements**: `36px` minimum height; `12px` horizontal padding
- **Mobile Optimization**: All targets increased to `44px × 44px` on small screens (xs–sm)

### Collapsing Strategy

- **Navigation**: Hamburger menu on `sm` and below; full horizontal nav on `md` and up
- **Grid Layouts**: Single column (`xs–sm`), two columns (`md`), three+ columns (`lg–xl`)
- **Sidebar**: Hidden on `xs–sm` (drawer/offcanvas), visible on `md` and up
- **Button Groups**: Stacked vertically on `xs–sm`, horizontal on `md` and up
- **Form Fields**: Full-width on `xs–md`, can pair side-by-side on `lg–xl`
- **Padding/Margins**: Reduced on `xs–sm` (`16px`), standard on `md` (`24px`), expanded on `lg–xl` (`32px–40px`)

## 9. Agent Prompt Guide

### Quick Color Reference

- **Primary CTA**: Black (`#000000`)
- **Secondary CTA**: White with border (`#FFFFFF`, border `#E5E5E5`)
- **Ghost/Text Button**: Transparent (`rgba(0, 0, 0, 0)`)
- **Text Color**: Black (`#000000`), secondary text gray (`#A1A1A1`)
- **Background**: White (`#FFFFFF`), soft background (`#FAFAFA`)
- **Borders**: Light gray (`#E5E5E5`)
- **Heading Text**: Black (`#000000`)
- **Accent/Link**: Blue (`#1447E6`)
- **Error**: Red (`#E40014`)
- **Focus Ring**: Blue (`#1447E6`)

### Iteration Guide

1. **Typography Foundation**: All UI text uses Geist; h1 48px/600, body 18px/400, labels 14px/500, inputs 14px/400
2. **Color Hierarchy**: Black for primary actions, white for surfaces, light gray (`#E5E5E5`) for borders, mid-gray (`#A1A1A1`) for secondary text
3. **Spacing Base**: 4px unit; use multiples for padding (16px, 24px), gaps (8px, 16px), and margins (12px, 20px)
4. **Button Styling**: Always 32px tall on desktop; primary is black, secondary is white with border; ghost is transparent with hover fill
5. **Card & Container Pattern**: 14px border-radius, 1px border (`#E5E5E5`), 16px–24px padding, soft shadow on elevation
6. **Input Styling**: 8px padding, 8px border-radius, `#E5E5E5` border, focus ring `#1447E6`; height 36px minimum
7. **Shadow Strategy**: Minimal on base; light cards use `0px 1px 2px rgba(0, 0, 0, 0.05)`; elevated use `0px 4px 6px rgba(0, 0, 0, 0.07)`
8. **Focus States**: Mandatory 2px ring (`#1447E6`) on all focusable elements; 2px offset for visibility
9. **Responsive**: Use px values tied to breakpoints (xs 320px, sm 480px, md 768px, lg 1024px, xl 1280px); single column on small, multi-column on large
10. **Accessibility**: Minimum 32px touch targets, 14px min text, high contrast (black on white), semantic HTML, focus indicators always visible