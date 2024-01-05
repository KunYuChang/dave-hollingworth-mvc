# dave-hollingworth-mvc

## 開發PHP應用程式時，如何有效組織程式碼

一開始，我們可能會把資料庫的連接代碼和 HTML 呈現的代碼混在一起，這對於簡單的腳本來說是可以接受的。但是，當應用程式開始擴展時，應用程式代碼（application code）和呈現代碼（presentation code）糾纏在一起，會變得難以維護。例如，我們可能需要不同的頁面顯示不同的資料，而這些頁面仍然需要與資料庫互動。

為了解決這個問題，我們可以將資料庫連接的程式碼放入單獨的檔案中，然後在需要資料庫訪問的所有其他檔案中引入它。同樣地，我們可能會創建一個專門的資料夾和文件來處理管理用戶的後台功能，這也需要與資料庫互動。

隨著檔案的增加，如果不進行良好的結構規劃，程式碼可能會變得雜亂難以管理。因此將應用程式代碼（application code）和呈現代碼（presentation code）進行分離。透過使用 MVC 模式，我們將程式碼分為Model,View,Controller，使其更有組織性。Controller處理與使用者的互動，Model處理資料，而View則負責呈現資料給使用者。這種結構有助於提高程式碼的可重複使用性、開發效率，同時提升安全性和可維護性。

## MVC命名慣例

在常見的程式設計慣例中，通常使用單數形式來表示模型（Model）的名稱，而使用複數形式來表示控制器（Controller）的名稱。這是為了反映模型通常代表單一實體或資料結構，而控制器可能負責多個操作或動作。

## MVC模式下的前端控制器：統一入口點的請求處理 (概念)

在傳統的 PHP 網站中，網址通常直接對應到檔案系統中的一個檔案和資料夾。然而，在MVC模式下，每一個請求都透過一個被稱為前端控制器（front controller）的檔案。這個獨立的腳本扮演著所有請求的中央入口點的角色，根據請求的內容來決定要運行哪個控制器和動作。由於請求基本上就是URL的內容，因此前端控制器利用URL的資訊來確定應當執行哪些操作。這種結構有助於提高程式碼的可維護性和可擴展性。

## 使用URL重寫 : 實現統一入口點 (實作)

為了實現所有請求都指向前端控制器並且兼具URL美觀，必須在Web伺服器層面進行配置，在Apache Web伺服器中，我們新增了一個名為.htaccess的檔案，並在其中設定URL重寫。打開重寫引擎，然後添加了一條重寫規則。這條規則的作用是將所有的URL都重寫為index.php。

換句話說，不再將URL直接映射到檔案系統中的某個檔案，而是將所有的請求都導向到前端控制器index.php，透過這樣的設定，我們成功地實現了URL和檔案系統的解耦，為框架提供了更大的自由度和可擴展性。

## 取得前端控制器中URL路徑的值

`$_SERVER['REQUEST_URI']` 是 PHP 中的一個超全域變數，它包含了從用戶端發送的 URL 請求中的 URI 部分。具體來說，REQUEST_URI 包含了域名之後的路徑以及任何查詢字串（Query String）。

## 使用parse_url移除查詢字串

移除查詢字串的主要原因是為了簡化URL的解析過程並確保框架能夠正確地處理控制器和動作。查詢字串通常包含在URL中，其中包含了額外的參數資訊，例如?id=123。這對於某些應用場景是有用的，但在這個特定的框架中，我們希望將控制器和動作的資訊包含在URL的路徑部分。雖然移除查詢字串可能會影響某些應用場景，例如需要在URL中攜帶大量動態參數的情況，但對於這個特定的框架，這是一個權衡，以實現更簡單和直觀的URL結構。

## 實現更靈活的路由管理 (概念)

在前一步驟中，我們已經能夠從URL中獲取控制器和動作的信息，但固定的URL結構會限制我們的應用。現在，我們希望實現更靈活的路由管理，以應對不同的URL結構和傳遞更多變數的需求。

為了實現這一目標，我們引入了路由（Route）的概念。路由是URL與特定控制器和動作的映射。我們將這些映射組織成一個路由表（Routing Table），由路由器（Router）進行管理。

## 自動載入與命名空間 (概念)

在 PHP 開發中，我們常面臨到如何有效組織程式碼、防止命名衝突的挑戰。命名空間和自動載入就是兩個關鍵的概念，讓我們更好地結構和維護我們的程式碼。

命名空間是一種將相關的類、函數和常數分組的方法，以防止命名衝突。透過 namespace 關鍵字，我們可以將一組相關的程式碼放在同一個命名空間中。

在過去，當我們需要使用某個類時，必須手動引入相應的檔案，這在大型專案中可能變得相當繁瑣。自動載入機制解決了這個問題，讓系統在需要時自動引入相應的檔案。

## 正規表達式

正規表達式（Regular Expressions）在程式語言中被廣泛用於搜尋、匹配和處理字串。在 PHP 中，正規表達式主要使用 PCRE（Perl Compatible Regular Expressions）函式庫。

https://www.php.net/manual/en/book.pcre.php
https://www.php.net/manual/en/regexp.reference.delimiters.php
https://www.php.net/manual/en/function.preg-match.php#refsect1-function.preg-match-returnvalues

### 正規表達式的開始與結束錨點

^ 和 $ 在正規表達式中是用來指定模式的開始和結束的錨點。
使用 ^ 表示模式必須出現在字串的開始位置。這是為了確保我們要匹配的模式不在字串的中間，只在開頭出現。使用 $ 表示模式必須出現在字串的結束位置。這確保了我們要匹配的模式不在字串的中間，只在結尾出現。

這兩個錨點的作用是為了更加精確地定義我們要搜尋或匹配的字串位置。如果我們省略了這些錨點，正規表達式可能會匹配到字串中的任何位置符合模式的部分，而不僅僅是開頭或結尾。

/abc/   => abc    => v
/abc/   => abcdef => v
/abc/   => bcdea  => x
/^abc/  => abc    => v
/^abc/  => abcdef => v
/^abc/  => 123abc => x
/abc$/  => 123abc => v
/^abc$/ => abc    => v
/^abc$/ => abcdef => v