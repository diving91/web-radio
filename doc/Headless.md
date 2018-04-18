## Headless configuration of the PI zero with Raspbian image

- Download Raspbian Stretch Lite image from official repo and load it on the SD card
- In boot partition add the following line in config.txt file
 `# hifiberry mini amp
 dtoverlay=hifiberry-dac`

