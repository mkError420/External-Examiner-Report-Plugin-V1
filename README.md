# External Examiner Report

Digital External Examiner Report Form for Medical Colleges.

## Description

This plugin provides a digital form for External Examiners to submit their reports for Medical Colleges. It is designed to streamline the reporting process for examinations.

### Key Features
- **Comprehensive Form**: Sections for Assessment Process (Formative & Summative), Student Performance, and Overall Comments.
- **User-Friendly Interface**: Toggleable radio buttons (click to deselect), required field indicators, and success confirmation popup.
- **Institution Branding**: Includes header for Rangpur Community Medical College Hospital (RCMCH).
- **Admin Dashboard**: Centralized view of all submitted reports.
- **Live Search**: Real-time filtering of reports by Teacher Name and Professional.
- **PDF Export**: Download individual reports as high-quality PDFs using `html2pdf.js`.
- **Bulk Management**: Delete multiple reports simultaneously via bulk actions.
- **Responsive Design**: Mobile-friendly form and dashboard interface.

## Installation

1. Upload the plugin files to the `/wp-content/plugins/external-examiner-report-v1` directory, or install the plugin through the WordPress plugins screen directly.
2. Activate the plugin through the 'Plugins' screen in WordPress.
3. Use the shortcode `[external_examiner_report]` on any page to display the form.
4. Go to the "Examiner Reports" menu in the admin dashboard to view submissions.
5. **Note**: An active internet connection is required for the PDF export feature (loads `html2pdf.js` via CDN).

## Shortcode

`[external_examiner_report]` - Displays the External Examiner Report form.

## Author

Mk. Rabbani