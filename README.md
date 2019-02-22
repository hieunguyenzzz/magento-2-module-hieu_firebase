# magento-2-module-hieu_firebase
synchronize data from Magento to firebase

change log:
1.0:

1. A new command for upload data to firestore: 

bin/magento firestore:sync

only simple product are support to upload into firestore at this version

2. server side authentication:

export GOOGLE_APPLICATION_CREDENTIALS=/path/to/json
