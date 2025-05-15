# Modern Elementor Contact Form

**modern-elementor-contact-form** is a lightweight, modern, and customizable contact form widget built specifically for the [Elementor](https://elementor.com) page builder. It allows users to easily create and manage email contact forms directly from the Elementor editor—no third-party form plugins needed.

---

## ✅ Features

- 🧩 Seamlessly integrates with Elementor  
- 📧 Sends messages directly via WordPress `admin-ajax.php` (PHP-based handling)  
- 🛠️ Customizable form fields: name, email, message  
- 🎨 Clean, responsive design with included CSS  
- ⚙️ JavaScript AJAX submission without page reload  
- 🔒 Basic validation and nonce security

---

## 🚀 Installation

Upload the folder to `/wp-content/plugins/` on your WordPress server.

Activate the plugin via the **Plugins** page in your WordPress dashboard.

---

## 🧰 Usage

1. Open the **Elementor Editor**.
2. Search for `Modern Contact Form` in the widget panel.
3. Drag the widget into your layout.
4. Configure:
   - **Recipient Email**
   - **Optional Webhook URL**
   - **Success/Error Messages**

---

## 🧪 Frontend Behavior

The form uses AJAX to send submissions without reloading the page.  
JavaScript handles the request via `form.js`, sending it to `admin-ajax.php` with:

```javascript
action: 'mecf_submit_form',
nonce: [secure_nonce],
name,
email,
message,
to_email,
webhook
```
## 💅 Styling

Basic form styling is handled in `form-style.css`:

```css
.mecf-form input, .mecf-form textarea {
    padding: 12px;
    width: 100%;
    border-radius: 4px;
}
```



