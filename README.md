![MageBootcamp Logo](https://magebootcamp.com/wp-content/uploads/2020/07/mbc_logo_export01.png)

# MageBootcamp Customer Fitness
MageBootcamp Customer Fitness is a simple module that allows your customer to 
add fitness progress to their customer account. Based on their progress we can calculate the BMI and show the results in a chart.

This module is free to use and is part of the MageBootcamp course. I've added extra comments in the module to
help you out learning Magento but also to use this module as reference.

If you need any help with this module, please let me know.

Kind regards,

Daniel Donselaar

[Mentor at MagebootCamp](https://magebootcamp.com)

[Daniel@MageBootcamp.com](mailto:daniel@magebootcamp.com)

## Installation
Setup a Magento 2 store with composer. Go to your Magento root directory and type in:
```
composer require 'magebootcamp/customerfitness';
```
After composer installation is complete:
```
php bin/magento module:enable MageBootcamp_CustomerFitness;
php bin/magento setup:upgrade;
```

To uninstall the module:
```
php bin/magento module:uninstall MageBootcamp_CustomerFitness;
```

## Features
### 1. Your customer can add their fitness progress in the customer account

After a customer is logged in the customer can go the 'My Fitness Progress' and add a new fitness log.

![Add new fitness log](https://magebootcamp.com/wp-content/uploads/2020/07/add-new-fitness-log.png)

> Add new fitness log

### 2. Fitness results are visible in a chart with BMI calculation

Your customer can keep track of their fitness progress. They see their progress in the chart or table.
The BMI is automatically calculated based on their length and weight. The module also looks at the Magento unit configuration (Metric or Imperial).

![Fitness progress chart](https://magebootcamp.com/wp-content/uploads/2020/07/my-fitness-log-chart.png)

> Fitness Progress Chart

### 3. [optionally] Sizes can be used to filter a size chart

`magebootcamp/sizechart is a composer dependency.`

The SizeChart module allows you to add a chest, waist, and hip size to your products. 
The customer can filter the sizes by pressing the 'Use my size' button that 
applies the sizes based on the 'My Fitness Progress' logs.

![MageBootcamp Logo](https://magebootcamp.com/wp-content/uploads/2020/07/customer-overview-page-customer-fitness-size-chart.png)

> 'Use my size' button that allows the customer to apply their account sizes.

## Support
Created by MageBootcamp: The Ultimate Online Magento Course.
We are here to help you become a Magento PRO.
Watch and learn at https://magebootcamp.com.

For feature requests, feedback and support, please contact [Daniel@MageBootcamp.com](mailto:daniel@magebootcamp.com)
