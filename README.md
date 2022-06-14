# TaxonomyEngine

Categorise your WordPress content with the assistance of machine learning and crowdsourcing

* This plugin is in early development. Use at own risk.

## What does it do?

TaxonomyEngine provides a *process* for _reliably_ tagging some of your existing content on your Wordpress website, trains a machine learning model based on your tagging, and then automagically tags the rest of your content. 

## How does it do it?

You decide which users are TaxonomyEngine content reviewers, and you define your taxonomy. The reviewer will have the opportunity to apply tags at the end of each article. The article isn't immediately tagged - you decide for each reviewer how much you trust them, and when they tag an article it gets a score based on that trust. Once it passes a threshold, we accept the tags as accurate. 

This means that you could require two interns to agree on a tag to accept an article, while a senior editor's tags could immediately accepted. If you crowdsource from your readers, perhaps you need ten of them to agree. Or five readers and one intern would approve the tagging.

As the system learns your article tagging based on your specific content, it will start suggesting tags. We track the accuracy of the machine learning predictions, and once it passes a defined point, we can autotag the historic corpus.

## Setting your own taxonomy

The default taxonomy is defined in /data/default_taxonomy.json. 

Each taxonomy item has the following keys:
- name: The name of the taxonomy item
- slug: A *unique* slug. Please ensure that you don't duplicate, else only one will be used.
- description: A short description of the taxonomy item
- question: A question to ask the reviewer when tagging (this is currently not displayed, but may be used in the future)
- children: An array of child taxonomy items using the same structure. It is not recommended to go further than three levels deep.
- parent: The parent taxonomy item. If this is absent, it is a top level taxonomy item

```json
[
    {
        "name": "Story purpose",
        "slug": "story-purpose",
        "description": "The reason that we decided to make this content",
        "question": "Why do you think DM decided to tell this story?",
        "children": [
            {
                "name": "Agenda-setting",
                "slug": "story-purpose-agenda-setting",
                "description": "to raise a new issue or bring a new perspective to an existing issue",
                "parent": "story-purpose"
            },
            {
                "name": "Analytical",
                "slug": "story-purpose-analytical",
                "description": "to break down a current issue and focus on the fundamentals with a view to carrying out further analysis",
                "parent": "story-purpose"
            }
        ]
    }
```

### Taxonomy Order

Wordpress orders taxonomies alphabetically, so unfortunately order is not maintained. However, we will always push "None" and "Other" to the end of the list.

## Installing from Source

### Installing dependencies

```
npm install
npm run build
composer update --ignore-platform-reqs
```

## The easy way to deploy

The repository https://github.com/MaverickEngine/taxonomy-engine-deploy includes a script to build the latest version of TaxonomyEngine, and is also a usable Wordpress plugin.

# Changelog

### v0.1.0

Basic functionality

### v0.2.0

- New taxonomy
- Description shown as tooltip
- "None" and "Other" always pushed to end of list
- "Reset" taxonomy

### v0.2.1

- Namespace CSS to avoid conflicts

### v0.2.2

- Customisable general instructions field
- Dismissable instructions
- Settings option to enforce the selection of a field before moving on to the next
- Better position of "Next" arrow

### v0.2.3

- Fix bug where DB versions weren't being compared correctly