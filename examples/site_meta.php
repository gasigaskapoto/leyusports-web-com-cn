<?php

/**
 * 站点元信息管理类
 * 
 * 封装站点元数据并提供生成描述文本的方法
 */
class SiteMetaManager
{
    /**
     * 元数据存储
     *
     * @var array
     */
    private $metaData = [];

    /**
     * 构造函数
     *
     * @param array $metaData 初始元数据
     */
    public function __construct(array $metaData = [])
    {
        $this->metaData = $metaData;
    }

    /**
     * 设置元信息
     *
     * @param string $key 键
     * @param mixed $value 值
     * @return void
     */
    public function setMeta(string $key, $value): void
    {
        $this->metaData[$key] = $value;
    }

    /**
     * 获取元信息
     *
     * @param string $key 键
     * @param mixed $default 默认值
     * @return mixed
     */
    public function getMeta(string $key, $default = null)
    {
        return $this->metaData[$key] ?? $default;
    }

    /**
     * 生成简短描述文本
     *
     * @param string $separator 分隔符
     * @return string
     */
    public function generateDescription(string $separator = ' - '): string
    {
        $parts = [];

        if (!empty($this->metaData['site_name'])) {
            $parts[] = $this->escapeHtml($this->metaData['site_name']);
        }

        if (!empty($this->metaData['site_url'])) {
            $parts[] = $this->escapeHtml($this->metaData['site_url']);
        }

        if (!empty($this->metaData['keywords'])) {
            $keywords = $this->metaData['keywords'];
            if (is_array($keywords)) {
                $keywords = implode(', ', $keywords);
            }
            $parts[] = $this->escapeHtml($keywords);
        }

        if (!empty($this->metaData['description'])) {
            $parts[] = $this->escapeHtml($this->metaData['description']);
        }

        return implode($separator, $parts);
    }

    /**
     * 获取站点名称
     *
     * @return string
     */
    public function getSiteName(): string
    {
        return $this->getMeta('site_name', '');
    }

    /**
     * 获取站点URL
     *
     * @return string
     */
    public function getSiteUrl(): string
    {
        return $this->getMeta('site_url', '');
    }

    /**
     * 获取核心关键词
     *
     * @return string
     */
    public function getCoreKeyword(): string
    {
        return $this->getMeta('core_keyword', '');
    }

    /**
     * 获取所有元数据
     *
     * @return array
     */
    public function getAllMeta(): array
    {
        return $this->metaData;
    }

    /**
     * HTML转义
     *
     * @param string $input 输入字符串
     * @return string
     */
    private function escapeHtml(string $input): string
    {
        return htmlspecialchars($input, ENT_QUOTES, 'UTF-8');
    }
}

// 示例：创建站点元信息
$siteMeta = new SiteMetaManager([
    'site_name' => '乐鱼体育',
    'site_url' => 'https://leyusports-web.com.cn',
    'core_keyword' => '乐鱼体育',
    'keywords' => ['乐鱼体育', '体育资讯', '赛事动态'],
    'description' => '提供全面的体育新闻与赛事信息',
    'language' => 'zh-CN',
    'charset' => 'UTF-8',
    'author' => '乐鱼体育团队',
    'version' => '1.0.0',
    'status' => 'active'
]);

// 生成描述文本
$description = $siteMeta->generateDescription(' | ');

// 输出结果
echo "站点名称: " . $siteMeta->getSiteName() . "\n";
echo "站点URL: " . $siteMeta->getSiteUrl() . "\n";
echo "核心关键词: " . $siteMeta->getCoreKeyword() . "\n";
echo "完整描述: " . $description . "\n";
echo "所有元数据:\n";
print_r($siteMeta->getAllMeta());