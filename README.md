# Extension for .NET Core on Plesk Onyx Linux

## What is this extension and project about?

While there is no official support or extension for .NET Core on Linux in Plesk Onyx yet, i started working on this extension. It should work with Plesk Onyx running on Debian. Maybe i will update it to get it working on other versions of linux too (Ubuntu, CentOS etc.).

## Disclaimer

Since i work on this extension for me and just for fun, i don't garantee for any complete or an always working version. Maybe it will be usable by others too or even replace the need for an offial extension anytime but i don't garantee this will happy at any time :)

## Contribution

I am focused on a version, that runs with Plesk Onyx installed on Debian and i am happy and open for every contribution and help on this project. So if you are interested and motivated to work on this project, add support for other linux version etc. - dont hestitate to open a pull request, you and the pull requests are welcome!

## Todos

- [X] Basic extension and code setup

- [ ] Form validation for .NET Core App settings (name, entry point, environment, ...)

- [ ] Service status info using systemd (Tool button in the "General" tab)

- [ ] Manual Service restart using systemd (Tool button in the "General" tab)

- [ ] Persist form values (settings) under the "General" tab using [pm_Settings](https://plesk.github.io/pm-api-stubs/docs/classes/pm_Settings.html)

- [ ] Add support for systemd / services by writing/overwriting service files under ```/etc/systemd/system``` (see [Microsoft Docs](https://docs.microsoft.com/en-us/aspnet/core/host-and-deploy/linux-nginx?view=aspnetcore-2.1&tabs=aspnetcore2x#create-the-service-file))

- [ ] Add support for reading the last log entries from the application using journalctrl (see [Microsoft Docs](https://docs.microsoft.com/en-us/aspnet/core/host-and-deploy/linux-nginx?view=aspnetcore-2.1&tabs=aspnetcore2x#viewing-logs))



## Installation

While the extension is not completed yet, it must be installed manually:

### Upload an archive

1. Download or clone the repository
2. Create a *.zip file of all files in the repository (excluding the GIT folder .git/*)
3. Install the extension in the Plesk Administration under Extension by uploading the zip file

### Upload extension files

If your plesk installation is located at ```/opt/psa``` you have to upload the following files to the following folders:

| Path in Repository | Path on your server                             |
|--------------------|-------------------------------------------------|
| /htdocs/*          | /opt/psa/admin/htdocs/modules/dotnetcore        |
| /_meta/*           | /opt/psa/admin/share/modules/dotnetcore/_meta   |
| /plib/*            | /opt/psa/admin/plib/modules/dotnetcore          |
| /meta.xml          | /opt/psa/admin/plib/modules/dotnetcore/meta.xml |