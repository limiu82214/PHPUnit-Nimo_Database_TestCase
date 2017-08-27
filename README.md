# PHPUnit-NimoDatabaseTestCase
為了更方便使用PHPUnit的資料庫測試而建立的Class

### 安裝
復製 _class/ 到你的測試資料夾。

### 使用方式
寫一個新的單元測試，並且繼承 NimoDatabaseTestCase 。
範例見 Nimo_Database_TestCase/ 。

### 方法
#### 設定登入資料庫資訊
SetLoginDatabaseInfo(DatabaseConnectBag);

#### 使用陣列來建立DataSet
createArrayDataSet(array);
