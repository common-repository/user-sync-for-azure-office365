=== User Sync & Business Directory for Azure AD / Azure B2C / Office 365 ===
Contributors: miniOrange
Donate link: https://miniorange.com
Tags: Business Directory, Azure AD/ B2C, User Sync, Office 365, User Provisioning, Group Provisioning
Requires at least: 5.5
Tested up to: 6.5
Requires PHP: 7.0
Stable tag: 2.0.4
License: MIT/Expat
License URI: https://docs.miniorange.com/mit-license

Create Business Directory and Bi-Directional User Synchronization with Azure AD, Azure B2C and Office 365. CPT, Taxonomies supported.

== Description ==

With User Sync and Business Directory plugin for Azure AD / Azure B2C and Office 365 plugin, you can create Active Directory users in WordPress and sync their Primary, Custom Attributes. The User Sync and Business Directory plugin also supports synchronization of Azure AD security groups to WordPress Roles. Additionally, you can save the attributes to either User Meta, Post Meta or any other Custom Post Type of your choice.

Establish hassle-free provisioning with the help of miniOrange Team and avail 24/7 Support for any kind of issues or assistance. Please contact us at 

👉 [Features](https://plugins.miniorange.com/wp-user-sync-for-azure-office365) 👉[Pricing](https://plugins.miniorange.com/wp-user-sync-for-azure-office365#pricing) 👉[Documentation](https://plugins.miniorange.com/azure-ad-user-sync-wordpress-with-microsoft-graph) 👉[Video](https://www.youtube.com/watch?v=UbeDfR1TOH0)

== ⚡ Use Cases ==

>⭐ __Business Directory and User Synchronization__
> 1. Real-Time User Data Create/Update/Delete
> 2. Profile Picture Synchronization
> 3. Sync Azure Security Groups to WordPress Roles 
> 4. Save data in User Meta, Post Meta or in Custom Post Type
> 5. Integration with GeoDirectory/Business Directory plugin for customizable interface

>⭐ __WooCommerce Customer Creation and Membership Management__
> 1. Register users from WooCommerce Checkout form directory in Azure B2C Directory
> 2. Assign users to Azure AD groups based on the membership purchased
> 3. Set password from WordPress to Azure B2C
> 4. Store additional details like Address, Phone, Emails, etc. to Custom Attributes in Azure
> 5. Real-Time synchronization on profile update and deletion

>⭐ __Send Emails using Microsoft Graph__
> 1. Send email on events like User Registration, Update, Deletion or Post Operations
> 2. Customizable Templates
> 3. Set the sender of the emails and read receipts

>⭐ __Audit Logs__
> 1. Get Email notification whenever user synchronization is failed or user details doesn't match the criteria
> 2. Log Storage upto 30 days

>⭐ __Integration with 3rd Party Plugins__
> 1. [WooCommerce](https://wordpress.org/plugins/woocommerce/)
> 2. [BuddyPress](https://wordpress.org/plugins/buddypress/)
> 3. [Ultimate Member – Login, Member Directory, Content Restriction & Membership Plugin](https://wordpress.org/plugins/ultimate-member/)
> 4. [Paid Memberships Pro – Content Restriction, User Registration, & Paid Subscriptions](https://wordpress.org/plugins/paid-memberships-pro/)
> 5. [GeoDirectory – Business Directory, Listings or Classified Directory](https://wordpress.org/plugins/geodirectory/)
> And many more

== ⚡ How Business Directory and User Sync plugin for Azure AD / Azure B2C Works ==
* **Microsoft Graph** - This is a standard way provided by microsoft to interact with data from various Microsoft Services Like Azure AD, B2C, Outlook, etc. To start the synchronization, you'll need to establish the secure OAuth2.0 Connection between your WordPress Site and Azure Directory. Most amazing thing about this approach is, this works with intranet site as well. This means you don't need to open or whitelist the site to establish the synchronization.

* **SCIM** - SCIM stands for "System for Cross-domain Identity Management." It's an open standard protocol that simplifies the management of user identities across different systems and services. Using the Azure AD Enterprise Application, you can enable the provisioning service that will send the updated user data to WordPress. 

== ⚡ What Features do Business Directory and User Sync plugin for Azure AD / Azure B2C offers? ==
* **
* **Manual/Ad-hoc User Synchronization (Azure AD/B2C to WordPress )** - User Sync & Business Directory for Azure AD / Azure B2C / Office 365 plugin allows you to synchronize the individual users from Azure AD/ Azure B2C/ Office 365. Put the object ID of the user you want to sync and click on Sync User to create the user on WordPress.

* **Send WordPress emails using Microsoft Graph** - User Sync & Business Directory for Azure AD / Azure B2C / Office 365 plugin allows you to send emails to the WordPress users using Microsoft Server and Microsoft Graph API. You can customize the email template and send it as a HTML Content. User Sync & Business Directory for Azure AD / Azure B2C / Office 365 plugin allows you to save sent emails to the account's sent items folder.

* **Automatic User Creation** - User Sync & Business Directory for Azure AD / Azure B2C / Office 365  plugin enables creation of all users from Azure AD/Azure B2C to WordPress and maintains seamless synchronization such that any changes made in Azure AD will be automatically reflected on WordPress.

* **Advanced Attribute Mapping** - User Sync & Business Directory for Azure AD / Azure B2C / Office 365 plugin allows you to synchronize and map advanced profile attributes like Job Info / Company Info / Contact details from Azure AD / Azure B2C user profile/employee directory information to wordpress user details. These details will be stored in the user_meta table and available to access through Advanced Custom fields. [ACF Supported]

* **Assign Content of Deleted Users** - While Automatic deletion of user you have an option to select the user to whom you want to assign the content of the deleted user.


* **Profile Picture Synchronization** - User Sync & Business Directory for Azure AD / Azure B2C / Office 365 plugin allows you to synchronize profile picture from Azure AD / Azure B2C user profile/employee information to the WP user gravatar.

* **WordPress to Azure AD Synchronization** - Feature to synchronize WordPress users to Azure AD a) Bulk Import - This feature creates a batch of all users present in your WordPress after that you can start the synchronization process allowing all users to be created in Azure AD if they are not created and updated if they are already there.  b) At the time of User creation/updation - this allows you to create/update users in Azure AD at the time when users are created/updated in WordPress

* **Group Provisioning** - User Sync & Business Directory for Azure AD / Azure B2C / Office 365 plugin allows you to synchronize Azure AD Security groups/Office365 groups/AzureB2C memberships to the WordPress site. This will also allow you to sync users dynamically only from certain mentioned Azure AD Security groups/Office 365 groups/AzureB2C memberships.

* **Scheduled Synchronization** - User Sync & Business Directory for Azure AD / Azure B2C / Office 365 plugin allows you to set a custom time interval after which users can be synchronized to the WordPress site. Once set, the plugin will call the Microsoft Graph API on the specified time to fetch the users from Azure AD / Azure B2C / Office 365 etc.

* **Auditing** - User Sync & Business Directory for Azure AD / Azure B2C / Office 365 plugin allows you to view and export the user synchronization logs with Azure AD/Azure B2C/Office 365. The logs will have details about the user details fetched, synchronization time and status of the update.

* **Support for Azure B2B [Guest Users are supported]** - User Sync & Business Directory for Azure AD / Azure B2C / Office 365 plugin allows you to synchronize Azure AD/Office 365 guest users to the WordPress site. The Azure B2B users will be created in WordPress with a tag of guest users.

* **Roles Synchronization** -User Sync & Business Directory for Azure AD / Azure B2C / Office 365 plugin allows you to Synchronize WordPress user roles to the corresponding security groups in Azure AD / Azure B2C / Office 365. You can map the user roles to the corresponding security groups in Azure AD / Azure B2C / Office 365.

* **Business Directory** - User Sync & Business Directory for Azure AD / Azure B2C / Office 365 plugin allows you to create an employee directory on WordPress with the help of other 3rd-party plugins like BuddyPress, BuddyBoss, Ultimate member etc. The synchronization of Azure AD/ Azure B2C/Office 365 Profile image to WordPress Gravatar/ BuddyPress Profile/ BuddyBoss Profile/ Ultimate Member profile is supported.

* **Integration with 3rd Party Providers** - Seamless Integrations with 3rd party plugins like :
> 1. Woo-Commerce (Bidirectional user sync)
> 2. Learndash
> 3. BuddyPress
> 4. Memberpress
> 5. Paid Membership Pro

* **Azure AD / B2C Multi-tenancy**
  Use single sign-on to allow users to access WordPress sites with their existing accounts in different Azure AD / B2C tenants and Directories. Seamless connection with different Azure AD / B2C tenants to your WordPress site.

* **Microsoft Power Apps Integration**
  The seamless access to your Power Apps. Azure Sync plugin integrations provides the functionality to embed your complex business logic and Power Apps workflows into your WordPress site.

* **Outlook Calendar/Mails Integration**
  Embed Microsoft Outlook calendar and mails on your WordPress pages. Schedule meetings, appointments with customers, view available dates easily. Sync the contacts bidirectionally between Outlook contacts and your WordPress database.

== Benefits ==

* **Bidirectional User Sync for Azure & WordPress**
  Two-way user synchronization from Azure AD/Azure B2C/Office 365 to WordPress. Automatically create users on WordPress for all users existing in Azure Active Directory as well as Create users in Azure B2C simultaneously while they register on the WordPress site via WooCommerce or BuddyPress with our seamless integrations.

* **Scheduled User Sync**
  Azure to WordPress sync can be scheduled at a specific time interval providing increased security and reduced costs by eliminating the possibility of idle user accounts and unauthorized information access.

* **24/7 Active Support**
  We provide world-class support and customers vouch for our support.

== Frequently Asked Questions ==

= How to configure the plugin ? =
You can follow the <a href="https://plugins.miniorange.com/azure-ad-user-sync-wordpress-with-microsoft-graph" target="_blank">Guide to configure User Sync for Azure AD Office365 plugin</a> and configure the plugin. If you face any issues please email us at <a href="mailto:office365support@xecurify.com">office365support@xecurify.com</a>. 

== Screenshots ==

1. User Sync for Azure AD / Azure B2C Plugin Configurations.
2. Profile Mapping Features.
3. User sync for Azure AD / Azure B2C Active Directory to Wordpress Database using Manual Provisioning, Automatic Provisioning, profile Picture Sync Feature.
4. User sync for WordPress Database to Azure Ad / Azure B2C Active Directory using Manual Provisioning and Automatic Provisioning.
5. Available integrations with WordPress using Microsoft Graph API.

If you require any help with installing this plugin, please feel free to email us at <a href="mailto:office365support@xecurify.com">office365support@xecurify.com</a> or <a href="http://miniorange.com/contact" >Contact us</a>.

== Website ==
> Check out our website for other plugins <a href="https://plugins.miniorange.com/wordpress" >https://plugins.miniorange.com/wordpress</a> or <a href="https://wordpress.org/plugins/search.php?q=miniorange" >click here</a> to see all our listed WordPress plugins.

For more support or info email us at <a href="mailto:office365support@xecurify.com">office365support@xecurify.com</a> or <a href="http://miniorange.com/contact " target=”_blank” >Contact us</a>.

== Installation ==

= From WordPress.org =
1. Download miniOrange User Sync & Directory Integration for Azure AD / B2C plugin.
2. Unzip and upload the `User Sync & Directory Integration for Azure AD / B2C` directory to your `/wp-content/plugins/` directory.
3. Activate User Sync & Directory Integration for Azure AD / B2C from your Plugins page.

= From your WordPress dashboard =
1. Visit `Plugins > Add New`.
2. Search for `User Sync & Directory Integration for Azure AD / B2C`. Find and Install `User Sync & Directory Integration for Azure AD / B2C`.
3. Activate the plugin from your Plugins page.

= Setup guidelines =

Configure and setup your <a href="https://plugins.miniorange.com/wordpress-azure-office365-integrations" target=”_blank”>User Sync & Directory Integration for Azure AD / B2C</a> plugin using our <a href="https://plugins.miniorange.com/azure-ad-user-sync-wordpress-with-microsoft-graph" target=”_blank”>comprehensive setup guide.</a>

= For any query/problem/request =
Visit Help & FAQ section in the plugin OR email us at <a href="mailto:office365support@xecurify.com">office365support@xecurify.com</a> or <a href="http://miniorange.com/contact">Contact us</a>.

== ChangeLog ==

= 2.0.4 =
* Added Outlook Calendar Integration
* Automatic App Connection Improvement.
* PHPCS fixes.


= 2.0.3 =
* Added Pre-Integrated Automatic App Support
* UI Improvements

= 2.0.2 =
* Security Vulnerability fixes
* Minor Bug fixes

= 2.0.1 =
* Sending mails using graph API
* Push user to Azure AD from user profiles
* UI Improvements
* bug fixes

= 1.0.9 =
* UI Improvements
* Few minor bug fixes

= 1.0.8 =
* Compatibility with WordPress 5.9
* Updated UI for Test Configuration [ Now you can view profile picture as well in the test ]
* Few minor bug fixes

= 1.0.7 =
* Added feature to sync individual user from WordPress to Azure AD.
* UI Improvements.

= 1.0.6 =
* UI Improvements.
* CSS caching issue resolved.

= 1.0.5 =
* UI Improvements.
* Integrations page added.

= 1.0.4 =
* Added guide link to setup the plugin settings.

= 1.0.3 =
* Added feature to sync an individual user.
* Updated UI.
* compatibility with 5.8

= 1.0.2 =
* Fixed feedback form
* Added Contact Us/Support feature

== Upgrade Notice ==

= 2.0.3 =
* Added Pre-Integrated Automatic App Support
* UI Improvements

= 2.0.2 =
* Security Vulnerability fixes
* Minor Bug fixes

= 2.0.1 =
* Sending mails using graph API
* Push user to Azure AD from user profiles
* UI Improvements
* bug fixes

= 1.0.9 =
* UI Improvements
* Few minor bug fixes

= 1.0.8 =
* Compatibility with WordPress 5.9
* Updated UI for Test Configuration [ Now you can view profile picture as well in the test ]
* Few minor bug fixes

= 1.0.7 =
* Added feature to sync individual user from WordPress to Azure AD.
* UI Improvements.

= 1.0.6 =
* UI Improvements.
* CSS caching issue resolved.

= 1.0.5 =
* UI Improvements.
* Integrations page added.

= 1.0.4 =
* Added guide link to setup the plugin settings.

= 1.0.3 =
* Added feature to sync an individual user.
* Updated UI.
* compatibility with 5.8

= 1.0.2 =
* Fixed feedback form
* Added Contact Us/ Support feature 