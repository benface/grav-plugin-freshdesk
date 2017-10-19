# Grav Freshdesk Plugin

This [Grav](https://github.com/getgrav/grav) plugin creates a ticket in your [Freshdesk](https://freshdesk.com) account when the user submits a form.

## Installing / Updating

You can install this plugin through the [Grav Package Manager (GPM)](http://learn.getgrav.org/advanced/grav-gpm):

    bin/gpm install freshdesk

This will install the plugin into your `/user/plugins` directory within Grav. To update to the latest version:

    bin/gpm update freshdesk

## Configuration

User configuration should go in `/user/config/plugins/freshdesk.yaml`. Here's a sample config file:

    enabled: true
    api_key: *******************
    domain: mysite

* `api_key` **(required)**: Your Freshdesk API key.
* `domain` **(required)**: The subdomain part of your Freshdesk URL (e.g. if your URL is `https://mysite.freshdesk.com`, then enter `mysite`).

## Usage

Here's how you would use this plugin in a page that contains a form:

    form:
        name: contact
        fields:
            -
                name: name
                label: 'Name'
                type: text
            -
                name: email
                label: 'Email Address'
                type: email
            -
                name: subject
                label: 'Subject'
                type: text
            -
                name: description
                label: 'Message'
                type: textarea
        buttons:
            - type: submit
              value: Submit
        process:
            -
                freshdesk:
                    name: '{{ form.value.name }}'
                    email: '{{ form.value.email }}'
                    subject: '{{ form.value.subject }}'
                    description: '{{ form.value.description|nl2br }}'

Let's look at the parameters of the `freshdesk` form action:

* `name`: Name of the requester.
* `email` **(required)**: Email address of the requester. If no contact exists with this email address in Freshdesk, it will be added as a new contact.
* `subject` **(required)**: Subject of the ticket.
* `description` **(required)**: HTML content of the ticket.

## Credits / Thanks

This plugin uses [Freshdesk PHP SDK API v2](https://github.com/mpclarkson/freshdesk-php-sdk).