Technology Stack
• Frontend: HTML5, CSS3, JavaScript (ES6+)
• Backend: PHP 8.x
• Database: MySQL managed via phpMyAdmin
⸻
Core Functional Requirements
1. User Account Management
• Clients: Self-registration pending staff/admin approval
• Staff & Admin: Instant account creation
• Secure login/logout with session handling
• Password flow:
• Onboarding: Email + select one of 10 security questions + answer + password + confirmation
• Recovery: Enter email → answer security question → reset password
• Profile editing (personal info, notification preferences, language)
2. Case Management
• Create, assign, view, update, close cases
• Role-based access controls to ensure confidentiality
• Full audit trail of case changes
3. Dynamic Intake & Referral Forms
• Modular questionnaires that expand conditionally based on responses
• Electronic submission with PDF export
• Automated referral routing to external partners via email/API
4. Consent Handling
• Embed digital consent at appropriate steps
• Store timestamped consent records
• Granular sharing permissions per record
5. Task & Reminder System
• Create/assign tasks with due dates
• Task acceptance or rejection tracking
• Automated email/SMS reminders
6. Messaging & Notifications
• One-to-one direct messages
• Group chats (restricted by role or case team)
• Broadcast channels for announcements
• Real-time in-app alerts and optional push/SMS
⸻
Additional Key Features
• Reporting & Analytics
• Interactive dashboards with charts and tables
• Exportable custom reports (CSV/PDF)
• Document Management
• Secure file upload/download
• Folder and tag-based organization
• Scheduling
• Integrated calendar for appointments
• Sync options (iCal/Google Calendar)
• Emergency Alerts
• One-click broadcast for urgent notifications (e.g., weather, shelter capacity)
• Learning & Resources Hub
• Library of handouts, videos, self-help guides
• Keyword search and categories
• Localization
• Interface translation (multi-language support)
• Date/time formatted per user locale
• Mobile-First Design
• Responsive layouts and touch-optimized components
• Audit & Security
• Detailed logs of all user actions
• Role-based permissions matrix
• HTTPS enforced with strong ciphers
• Integrations
• RESTful API endpoints for external systems
• Webhooks for real-time data sync
• Feedback Loop
• In-app surveys and rating prompts
• Quarterly user satisfaction reports
⸻
Role-Based Features
A. Common to All Users
• Secure authentication
• Responsive dashboard with key widgets
• Real-time form validation
• Dark/light mode toggle
• Notification centre with history
• In-app help tooltips and FAQ
• File preview (images, PDFs)
• Multi-step modal dialogs for complex tasks
• Activity feed showing recent actions
• Inline feedback (surveys, thumbs-up/down)
⸻
B. Client-Specific
• Intake & Assessment: Guided questionnaires with progress bars
• Case Overview: Read-only view of own cases, upcoming appointments, tasks
• Chat with Staff: Direct messaging only with assigned staff
• Self-Service: Ability to request referrals, view resource library
• Consent Dashboard: Review and revoke consent grants
• Personal Calendar: Schedule view of upcoming sessions/reminders
• Quick Actions: “Request Help,” “Update Profile,” “View Documents” buttons
• Progress Trackers: Visual indicators for treatment milestones
• Feedback Forms: Rate services immediately after appointments
⸻
C. Staff-Specific
• Client Intake: Launch and monitor dynamic forms for clients
• Case Assignment: Assign or reassign cases to team members
• Referral Management: Approve or adjust automated referrals
• Team Messaging: Group chats per case or program
• Task Queue: View all outstanding tasks, filter by due date/priority
• Analytics Widgets: Snapshot of caseload volumes and outcomes
• Document Approval: Review and sign off client-uploaded files
• Consent Overrides: Temporarily override consent with audit logging
• Training Hub Access: Recommend resources to clients or peers
⸻
D. Admin-Specific
• User Management: Create/edit/deactivate any account; bulk imports
• System Configuration: Manage security questions, email/SMS templates
• Role & Permission Control: Define new roles or adjust capabilities
• Global Reports: Export organization-wide metrics (funding, capacity)
• API & Integration Keys: Provision and revoke external access tokens
• Audit Trail Viewer: Drill down on all system events by user or date
• Emergency Broadcast: Send system-wide alerts (mobile push, SMS, email)
• Resource Library Admin: Upload or archive learning materials
• Backup & Restore: Trigger database backups and manage retention 🧑‍🤝‍🧑 Client-Specific Features (50)
1. Geo-located Service Finder – Map of nearest shelters, clinics, drop-in centres
2. Offline Mode – Fill forms without connectivity; sync when back online
3. Push Notifications – Appointment reminders, new messages, emergency alerts
1. Mood & Symptom Journal – Daily check-ins with optional free-text notes
2. Medication Reminders – Schedule, snooze, and confirm dosage alerts 8.
3. Peer Support Forum Access – Join moderated groups by topic (recovery, housing)
4. Accessibility Toolbar – Text resizing, high-contrast toggle, dyslexia font
5. Video Chat with Staff – Secure, in-app tele-health sessions
6. Personal Goal Planner – Set SMART goals and track milestones
7. Habit-Building Reminders – Daily self-care checklists (hydration, sleep)
8. Document Scanner – Snap ID or referral docs; auto-crop and upload
9. Resource Bookmarking – “Star” services for quick return visits
10. Waitlist Notifications – Alerts when beds, appointments, or services open up
11. Transportation Scheduler – Book rides or view transit options
12. Event Calendar – Local workshops, peer-led groups, training sessions
13. Digital Consent Hub – See who has access to your data; revoke anytime
14. Progress Badge System – Earn achievements (e.g. “First intake complete”)
15. Wellness Tips Feed – Daily mental-health/self-care micro-articles
16. Automated Follow-up Prompts – “How are things since your last appointment?”
17. Custom Dashboard Widgets – Choose which stats/info show up first
18. Interactive Consent Walkthrough – Animated explainer before signing
19. Emergency Contact Quick Dial – Pre-set trusted contacts
20. Live Chatbot Triage – 24/7 AI helper for basic questions
21. Resource Rating – Rate services and see community feedback
22. Document e-Signature – Sign consent or referral forms in-app
23. Data Export – Download your case history as PDF or CSV
24. One-Time Passcodes (OTP) – Extra security for sensitive actions
25. Profile Verification Badge – Optional ID verification with local agency
26. Finite-State Form Logic – Skip irrelevant questions automatically
27. Interactive Tutorials – Step-by-step video guides for new features
28. Referral Status Tracker – See when and how your referral was processed
29. Client-to-Client Mentorship Match – Opt in to mentor or be mentored
30. Live Service Availability – Real-time bed/vaccine/test-kit counts
31. Anonymous Feedback Channel – Send suggestions without needing an account
32. Voice-Activated Navigation – Basic voice commands (“Open my cases”)
33. Drag-and-Drop File Upload – Rearrange attachments before sending
34. Session Timeout Countdown – Visible timer before auto-logout
35. Multi-Media Resource Hub – Podcasts, videos, and infographics
36. Daily Affirmations Widget – Positive messages on your home screen
37. Contextual Help Popovers – Hover/tap icons for instant tips
38. Geo-Fence Notifications – Alerts when you enter/leave defined safe zones
39. “My Journey” Timeline – Visual history of your case milestones
⸻
👩‍💼 Staff-Specific Features (50)
1. Caseload Heatmap – Visualize client density by neighbourhood
2. Automated Risk Scoring – Flag high-risk clients based on criteria
3. Shift & On-Call Scheduler – Manage availability and coverage
4. SOAP Note Templates – Pre-built clinical note formats
5. Bulk Task Assignment – Allocate multiple follow-ups at once
6. Incident Report Forms – On-the-fly logging of critical events
7. QR-Code Check-in – Clients scan to verify attendance
8. Referral Partner Directory – Search external agencies by service type
9. Inventory Tracker – Monitor harm-reduction supplies stock levels
10. Mobile Check-In App – Offline data capture for street outreach
11. Case Note Auto-Summarization – AI-generated highlights from notes
12. Multi-Client View – Side-by-side comparison of several cases
13. Task Load Balancer – AI suggests equitable task distribution
14. Team Chat Channels – Topic-based Slack-style messaging
15. Peer-Supervision Module – Request case reviews from senior staff
16. Custom Form Builder – Drag-and-drop create new questionnaires
17. Client Geo-Tracking (with consent) – Live map of field visits
18. Training Progress Tracker – See which modules each staff has completed
19. Automated Follow-up Reminders – Nudges when clients miss appointments
20. Protocol & Checklist Library – Always-available procedure documents
21. Document e-Signing for Clients – Send and sign forms remotely
22. SMS Outreach Tool – Send group texts to clients or cohorts
23. Bulk Email Campaigns – Newsletters, program updates, surveys
24. Case Closure Wizard – Guided steps to properly close a file
25. Burnout Risk Alerts – Track staff hours and flag overwork
26. Grant & Funding Tracker – See which cases tie to which grant dollars
27. Compliance Dashboard – HIPAA/GDPR checkpoint summaries
28. API Playground – Test calls to partner-agency integrations
29. Automated Data Exports – Scheduled CSV/PDF dumps for reports
30. Client Outcome Analytics – Measure progress across cohorts
31. Maintenance Mode Toggle – Quickly disable front-end in an emergency
32. Onboarding Checklist – Ensure new hires complete all setup steps
33. Resource Availability Alerts – Low-stock or service downtime warnings
34. Case Transfer Workflow – Safe hand-off between staff members
35. Customizable Staff Roles – Fine-tune privileges per person
36. Video Conferencing Integration – Launch Zoom/WebRTC calls in-app
37. Analytics Drilldowns – Click into charts for client-level detail
38. Data Quality Reports – Identify missing or inconsistent entries
39. Notification Templates – Save and reuse common message formats
40. Digital Whiteboard – Brainstorm solutions with colleagues
41. External Partner Portal – Invite non-staff agencies to collaborate
42. Bulk Import Wizard – Upload client lists via Excel/CSV
43. Audit Log Viewer – See who did what, and when
44. Field-worker GPS Checkpoints – Confirm street outreach visits
45. Resource Request Queue – Staff request supplies from admin
46. Custom Dashboards – Personalize KPIs on your home screen
47. Heatmap of Service Usage – Identify under-served ZIP codes
48. Smart Form Suggestions – AI recommends next questions based on answers
49. Recurring Task Automations – Weekly check-ins auto-generated
50. Peer-to-Peer Feedback Module – Rate and comment on colleagues’ work
⸻
🛠️ Admin-Specific Features (50)
1. Global User Search – Find any account by name, email, or ID
2. Role & Permission Matrix – Visual editor for access controls
3. Single-Sign-On (SSO) & SAML – Integrate with corporate identity providers
4. LDAP / Active Directory Sync – Bulk user provisioning from your directory
5. Custom Branding – Upload logos, colors, fonts—and push org-wide
6. Feature Flags – Turn features on/off per group or environment
7. Data Retention Policies – Auto-archive or purge old records
8. Automated Backups – Schedule and store DB/file backups securely
9. Disaster Recovery Drill Mode – Test restore procedure without impact
10. System Health Dashboard – Uptime, CPU, memory, error rates
11. API Key Management – Issue, revoke, and monitor external keys
12. Webhook Event Logs – See delivered and failed notifications
13. Maintenance Mode Scheduler – Plan downtime windows with messaging
14. Compliance Toolkit – Templates and checklists for audits (HIPAA, PIPEDA)
15. Audit Log Exporter – Download user-activity history for regulators
16. Encryption Key Rotation – Schedule regular crypto key updates
17. Certificate Manager – Upload/renew SSL and client certificates
18. Consent Template Library – Edit and version consent forms centrally
19. Email & SMS Template Builder – WYSIWYG editor for all system messages
20. Third-Party Integration Hub – Manage OAuth, API endpoints, webhooks
21. Data Import/Export Wizards – Map CSV columns to DB fields visually
22. User Impersonation – Safely view the app as any client or staff
23. Error & Exception Dashboard – Track, triage, and resolve bugs
24. Rate-Limiting Controls – Protect APIs from abuse or spikes
25. Maintenance Announcements – Banner editor for system-wide alerts
26. Feature Usage Analytics – See which modules get the most traffic
27. Custom Field Definitions – Add new data fields without code
28. Sandbox Environment Switch – Toggle between prod, staging, dev
29. Release Notes Viewer – Built-in changelog for your team
30. Security Incident Workflow – Triage and track breaches or alerts
31. Session Management – View and revoke active user sessions
32. Two-Factor Enforcement – Require 2FA by role or globally
33. Password Policy Settings – Complexity, expiration, reuse rules
34. IP Whitelisting / Blacklisting – Control where users can log in from
35. GDPR / PIPEDA Rights Portal – Manage data-access and erasure requests
36. OCR Document Processing – Auto-extract text from uploads
37. OCR Review Queue – Validate or correct extracted data
38. API Sandbox Keys – Grant partners limited test-mode access
39. LDAP Group Mapping – Sync directory groups to roles automatically
40. Feature Usage Alerts – Notify when new features exceed thresholds
41. Custom SAML Metadata – Import/export SSO configs
42. Geo-Redundancy Controls – Route traffic across multiple data centers
43. Automated License Metering – Track seat usage and overages
44. Custom Domain Support – White-label portals per partner
45. Data Anonymization Tool – Mask PII for research or testing
46. Automated Sanitization – Scrub PHI/PII from logs after X days
47. Admin Audit Notifications – Instant alerts for privileged actions
48. Bulk Account Deactivation – Deactivate by filter (e.g. inactive 90+ days)
49. Compliance Report Generator – One-click PDF summary for auditors
50. Feature Roadmap Dashboard – Plan, vote, and track upcoming work
⸻
🎨 UI/UX / Theme & Interface Enhancements
1. Design System & Component Library – Reusable, accessible UI building blocks
2. Adaptive Color Themes – Auto-switch based on time of day or user preference
3. Micro-interactions – Subtle animations on button clicks, form submissions
4. Skeleton Screens – Reduce perceived load time with placeholder content
5. Progressive Disclosure – Show only what’s needed, reveal more on demand
6. Command-Palette Launcher – Keyboard-driven “Command+K” for navigation
7. Contextual Tooltips – Inline help when hovering ambiguous fields
8. Drag-and-Drop Customization – Rearrange dashboard widgets freely
9. Voice & Chatbot UIs – Offer AI assistant for quick Q&A
10. Fluid Typography – Text scales smoothly across breakpoints
11. Responsive Grid System – 12-column flex/grid for consistent layouts
12. Dark & High-Contrast Modes – WCAG AAA–compliant palette options
13. Sticky/Floating Action Buttons – Always-on “New Case” or “SOS”
14. Mega-Menus – For complex navigation with grouped links
15. Bottom Nav (Mobile) – Thumb-friendly access to key sections
16. Inline Validation Feedback – Instant error/success states on inputs
17. Empty-State Illustrations – Friendly graphics guiding first-time users
18. A/B Testing Framework – Rapidly try different UI flows on small cohorts
19. Heatmap Analytics – Visualize where users click or drop off
20. Accessibility Audit Tool – Built-in checker for color contrast, labels
21. Offline Status Indicator – Clearly show when user is disconnected
22. Split-Screen (Desktop) – Work on case notes alongside calendar view
23. Sticky Table Headers & Columns – Keep important data in view
24. Infinite Scroll with “Load More” – For long lists, reduce paging friction
25. Card-Based Resource Listings – Visual, bite-sized chunks of info
26. Interactive Charts – Hover-to-drill-into metrics on dashboards
27. Breadcrumbs – Always know your place in nested menus
28. Back-to-Top Button – User doesn’t get lost in long pages
29. Guided Walkthroughs – Step-by-step “first use” tours
30. Localization Switcher – Flag icon or dropdown to change language
31. ARIA Landmark Roles – Screen-reader friendly structural tags
32. Gesture Support (Mobile) – Swipe to archive, pinch to zoom
33. Full-Screen Mode – Hide navbar for focused writing or forms
34. Contextual Quick Actions – Hover-to-reveal row-specific buttons
35. System-Wide Search Bar – Instant fuzzy-search across clients, docs, tasks
36. Transparent Modals – Lightly dim background to maintain context
37. Loading Spinners with Tips – Entertainment or guidance during waits
38. Graphical Consistency – Unified icon set (SVG) with a single style
39. Session Resume Prompts – “You left off midway here—resume?”
40. Mobile-First Layouts – Design narrow screens first, then scale up
41. High-Density Data Tables – Configurable row heights, compact mode
42. Quick-Reply Buttons – Pre-written responses for common messages
43. Voice Narration Mode – Read out critical alerts or instructions
44. Sticky Notifications Drawer – Slide-out panel for recent alerts
45. Real-Time Collaboration Cursors – See other staff editing live
46. Customizable Keyboard Shortcuts – Power-user efficiency boost
47. In-Line Video Playback – Watch resource clips without leaving the page
48. Interactive Whiteboard Embeds – Brainstorm or diagram in-app
49. Automated “Jump To” Links – One-click scroll to unfinished sections
50. User Persona Previews – Toggle between “Client,” “Staff,” and “Admin” views
⸻
What is OUTSINC?
OUTSINC is a comprehensive, client-centered platform designed to support individuals facing homelessness, addiction, and mental health challenges. Our integrated system connects clients, outreach workers, and service providers for seamless case management, referrals, and support.
*  DCIDE: Case Management
*  LINK: Referral Engine
*  BLES: Intake & Recovery
*  ASK: Crisis & Support Chat
*  ETHAN: Wellness & Growth
*  Footprint: Progress Tracking
Our Services
Housing Assistance - Navigation, applications, and support for stable housing.
Mental Health - Access to counseling, crisis support, and peer groups.
Addiction Recovery- Harm reduction, detox referrals, and aftercare planning.
Employment Support - Job search, resume help, and training programs.
Legal & Financial Aid - Assistance with legal issues, documentation, and benefits.
 DCIDE
Driving Change, Inspiring Development Everywhere — Case Management Core
What is DCIDE?
DCIDE is the heart of OUTSINC's case management system, empowering outreach workers, social service providers, and advocates to track progress, manage support plans, and coordinate care for individuals facing homelessness, addiction, and mental health challenges.
* Client-Centered Case Creation: Quick intake, risk indicators, and support for complex cases.
* Dynamic Case Dashboard: Timeline view, progress snapshots, and centralized notes.
* Task & Appointment Management: Assign, track, and sync tasks and follow-ups.
* Resource Navigation: Match clients to services and track referrals.
* Safety & Crisis Tracking: Crisis alerts, safety plans, and real-time updates.
* Document Handling: Upload and manage consents, IDs, and assessments.
What is LINK?Lead Individuals to New Knowledge — Smart Referral Engine
LINK is OUTSINC's dynamic referral hub, connecting individuals to the right programs and services based on their current needs. Whether it's food, housing, counseling, or detox, LINK ensures no referral gets lost in translation.
* Service Search: Find programs by type, location, or urgency.
* Trackable Referrals: Real-time status updates and provider feedback.
* Smart Match Suggestions: Automatic recommendations based on client needs.
* Provider Directory: Up-to-date info on local agencies and resources.
* Follow-Up Tools: Calendar reminders and referral outcome tracking.
What is BLES? Breaking Life’s Endless Struggles — Intake & Recovery Support
BLES is OUTSINC’s specialized intake and recovery support platform, streamlining access to addiction recovery beds and advocacy for clients seeking treatment. BLES captures vital data, treatment goals, and consents to enable fast-tracked referrals and support.
* Recovery-Focused Intake: Custom forms for addiction history, needs, and risk evaluation.
* Consent & Advocacy: Digital signatures and staff follow-up for urgent cases.
* Referral Tracking: Monitor progress from intake to placement and aftercare.
* Urgency Flags: Automatically prioritize high-risk clients for outreach.
* Integrated Support: Connects with partner programs and recovery resources.
What is ASK? Access Support Knowledge — Live Support & Crisis Chat
ASK is OUTSINC’s live support chat and crisis line platform, bridging the digital divide by making real-time help available to anyone, anywhere. Whether it’s 2 AM or mid-crisis, ASK delivers human connection when it matters most.
* Live One-on-One Chat: Real-time support with staff or peer supporters.
* Public & Private Messaging: Flexible options for privacy and group support.
* Voice Notes: Audio messaging for accessibility and low-literacy users.
* Alert Keywords: Automatic flagging for high-risk situations.
* FAQ & Help Center: Searchable articles and quick answers for common issues.
What is ETHAN? Everything That’s Human And Normal — Wellness, Learning & Growth
ETHAN is OUTSINC’s wellness, learning, and growth platform, designed to help clients build daily routines, self-awareness, and positivity. ETHAN encourages creativity, reflection, and emotional resilience through interactive tools and personal development modules.
* Mood & Wellness Tracker: Emoji scale, sleep, meals, and medication logs.
* Personal Journals: Text, photo, and voice entries for self-reflection.
* Learning Modules: Quizzes, videos, and mini-games for skill-building.
* Habit Builder: Daily routines, streak tracking, and achievement badges.
* Positive Feedback: Encouragement, badges, and progress visualization.
What is FOOTPRINT?
FOOTPRINT is OUTSINC’s outreach, incident logging, and reporting platform. It documents field activities, tracks harm reduction supply distribution, and visualizes program impact through dynamic dashboards and analytics.
* Incident Reporting: Online forms for litter, illegal dumping, and outreach logs.
* Outreach Activity Tracking: Document field encounters, services provided, and follow-ups.
* Impact Visualization: Charts, heatmaps, and exportable reports for stakeholders.
* Document Archive: Store and retrieve consents, forms, and case notes.
* System Integrity: Automated checks, error logs, and system health monitoring.
