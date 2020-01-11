# Changelog

## [0.4.1](https://github.com/typisttech/imposter/tree/0.4.1) (2020-01-11)

[Full Changelog](https://github.com/typisttech/imposter/compare/0.4.0...0.4.1)

**Merged pull requests:**

- `ArrayUtil`: Remove dead code [\#89](https://github.com/TypistTech/imposter/pull/89) ([TangRufus](https://github.com/TangRufus))
- Export `composer.lock` [\#88](https://github.com/TypistTech/imposter/pull/88) ([TangRufus](https://github.com/TangRufus))

## [0.4.0](https://github.com/typisttech/imposter/tree/0.4.0) (2020-01-11)

[Full Changelog](https://github.com/typisttech/imposter/compare/0.3.1...0.4.0)

**Fixed bugs:**

- Bug: Imposter transforms variables with `namespace` keyword [\#79](https://github.com/TypistTech/imposter/issues/79)

**Closed issues:**

- Return value of TypistTech\Imposter\ArrayUtil::flatten\(\) must be of the type array, null returned [\#76](https://github.com/TypistTech/imposter/issues/76)
- Better error messages when required packages don't define the `autoload` fields [\#57](https://github.com/TypistTech/imposter/issues/57)

**Merged pull requests:**

- Version bump 0.4.0 [\#87](https://github.com/TypistTech/imposter/pull/87) ([TangRufus](https://github.com/TangRufus))
- Bikeshedding [\#86](https://github.com/TypistTech/imposter/pull/86) ([TangRufus](https://github.com/TangRufus))
- Fix `array\_merge` exception when `autoload`is not defined in package `composer.json` [\#85](https://github.com/TypistTech/imposter/pull/85) ([TangRufus](https://github.com/TangRufus))
- Bump PHP requirement to ^7.2; Update dependencies; Apply code style [\#84](https://github.com/TypistTech/imposter/pull/84) ([TangRufus](https://github.com/TangRufus))
- Replace TravisCI with CircleCI [\#83](https://github.com/TypistTech/imposter/pull/83) ([TangRufus](https://github.com/TangRufus))
- Do not transform `$namespace` variables [\#82](https://github.com/TypistTech/imposter/pull/82) ([TangRufus](https://github.com/TangRufus))
- Readme: Add badge - PHP from Packagist [\#74](https://github.com/TypistTech/imposter/pull/74) ([TangRufus](https://github.com/TangRufus))
- Readme: Fix broken link [\#73](https://github.com/TypistTech/imposter/pull/73) ([TangRufus](https://github.com/TangRufus))

## [0.3.1](https://github.com/typisttech/imposter/tree/0.3.1) (2018-09-24)

[Full Changelog](https://github.com/typisttech/imposter/compare/0.3.0...0.3.1)

**Closed issues:**

- Bug: Wrong transformation of `use function` keywords [\#65](https://github.com/TypistTech/imposter/issues/65)

**Merged pull requests:**

- Version bump 0.3.1 [\#72](https://github.com/TypistTech/imposter/pull/72) ([TangRufus](https://github.com/TangRufus))
- Transformer: Test closures with `use` keywords [\#71](https://github.com/TypistTech/imposter/pull/71) ([TangRufus](https://github.com/TangRufus))
- Better testing dummies [\#70](https://github.com/TypistTech/imposter/pull/70) ([TangRufus](https://github.com/TangRufus))
- Transform `use const` and `use function` keywords [\#69](https://github.com/TypistTech/imposter/pull/69) ([TangRufus](https://github.com/TangRufus))
- Apply code style [\#68](https://github.com/TypistTech/imposter/pull/68) ([TangRufus](https://github.com/TangRufus))
- Do not use `final`; Use Mockery instead of AspectMock [\#67](https://github.com/TypistTech/imposter/pull/67) ([TangRufus](https://github.com/TangRufus))
- Bump PHP requirement to `^7.1`; Normalize as other Typist Tech projects [\#66](https://github.com/TypistTech/imposter/pull/66) ([TangRufus](https://github.com/TangRufus))
- Misc: Update TravisCI & readme & info [\#63](https://github.com/TypistTech/imposter/pull/63) ([TangRufus](https://github.com/TangRufus))
- Readme: Update links and info [\#62](https://github.com/TypistTech/imposter/pull/62) ([TangRufus](https://github.com/TangRufus))

## [0.3.0](https://github.com/typisttech/imposter/tree/0.3.0) (2018-01-16)

[Full Changelog](https://github.com/typisttech/imposter/compare/0.2.3...0.3.0)

**Fixed bugs:**

- Double backslashes being added [\#58](https://github.com/TypistTech/imposter/issues/58)

**Merged pull requests:**

- Version bump 0.3.0 [\#61](https://github.com/TypistTech/imposter/pull/61) ([TangRufus](https://github.com/TangRufus))
- composer update [\#60](https://github.com/TypistTech/imposter/pull/60) ([TangRufus](https://github.com/TangRufus))
- Handle `use` keywords with leading backslashes [\#59](https://github.com/TypistTech/imposter/pull/59) ([TangRufus](https://github.com/TangRufus))
- Misc: Add tests/\_output/.gitignore [\#56](https://github.com/TypistTech/imposter/pull/56) ([TangRufus](https://github.com/TangRufus))
- Misc: Typist Tech code style [\#55](https://github.com/TypistTech/imposter/pull/55) ([TangRufus](https://github.com/TangRufus))

## [0.2.3](https://github.com/typisttech/imposter/tree/0.2.3) (2017-10-22)

[Full Changelog](https://github.com/typisttech/imposter/compare/0.2.2...0.2.3)

**Closed issues:**

- Disable codecov.io pull request commenting [\#46](https://github.com/TypistTech/imposter/issues/46)

**Merged pull requests:**

- Version bump 0.2.3 [\#54](https://github.com/TypistTech/imposter/pull/54) ([TangRufus](https://github.com/TangRufus))
- TravisCI: Run tests against lowest and highest dependencies [\#53](https://github.com/TypistTech/imposter/pull/53) ([TangRufus](https://github.com/TangRufus))
- Scrutinizer: Remove `align\_assignments` [\#52](https://github.com/TypistTech/imposter/pull/52) ([TangRufus](https://github.com/TangRufus))
- Fix broken link [\#51](https://github.com/TypistTech/imposter/pull/51) ([TangRufus](https://github.com/TangRufus))
- composer update [\#50](https://github.com/TypistTech/imposter/pull/50) ([TangRufus](https://github.com/TangRufus))
- Rename: CONDUCT.md --\> CODE\_OF\_CONDUCT.md [\#49](https://github.com/TypistTech/imposter/pull/49) ([TangRufus](https://github.com/TangRufus))
- Disable codecov.io pull request commenting [\#47](https://github.com/TypistTech/imposter/pull/47) ([TangRufus](https://github.com/TangRufus))

## [0.2.2](https://github.com/typisttech/imposter/tree/0.2.2) (2017-03-25)

[Full Changelog](https://github.com/typisttech/imposter/compare/0.2.1...0.2.2)

**Merged pull requests:**

- Version bump 0.2.2 [\#45](https://github.com/TypistTech/imposter/pull/45) ([TangRufus](https://github.com/TangRufus))
- Fix: Transform single level namespace [\#44](https://github.com/TypistTech/imposter/pull/44) ([TangRufus](https://github.com/TangRufus))

## [0.2.1](https://github.com/typisttech/imposter/tree/0.2.1) (2017-03-25)

[Full Changelog](https://github.com/typisttech/imposter/compare/0.2.0...0.2.1)

**Merged pull requests:**

- Version bump 0.2.1 [\#43](https://github.com/TypistTech/imposter/pull/43) ([TangRufus](https://github.com/TangRufus))
- Skip global namespace [\#42](https://github.com/TypistTech/imposter/pull/42) ([TangRufus](https://github.com/TangRufus))

## [0.2.0](https://github.com/typisttech/imposter/tree/0.2.0) (2017-03-25)

[Full Changelog](https://github.com/typisttech/imposter/compare/0.1.1...0.2.0)

**Merged pull requests:**

- Version bump 0.2.0 [\#41](https://github.com/TypistTech/imposter/pull/41) ([TangRufus](https://github.com/TangRufus))
- Exclude project config from collection [\#40](https://github.com/TypistTech/imposter/pull/40) ([TangRufus](https://github.com/TangRufus))

## [0.1.1](https://github.com/typisttech/imposter/tree/0.1.1) (2017-03-24)

[Full Changelog](https://github.com/typisttech/imposter/compare/0.1.0...0.1.1)

**Closed issues:**

- Suggest typisttech/imposter-plugin [\#32](https://github.com/TypistTech/imposter/issues/32)

**Merged pull requests:**

- Version bump 0.1.1 [\#39](https://github.com/TypistTech/imposter/pull/39) ([TangRufus](https://github.com/TangRufus))
- Use custom filesystem instead of illuminate/filesystem [\#38](https://github.com/TypistTech/imposter/pull/38) ([TangRufus](https://github.com/TangRufus))
- Test against highest and locked composer dependencies [\#37](https://github.com/TypistTech/imposter/pull/37) ([TangRufus](https://github.com/TangRufus))
- Suggest typisttech/imposter-plugin [\#34](https://github.com/TypistTech/imposter/pull/34) ([TangRufus](https://github.com/TangRufus))
- Update code style config [\#33](https://github.com/TypistTech/imposter/pull/33) ([TangRufus](https://github.com/TangRufus))

## [0.1.0](https://github.com/typisttech/imposter/tree/0.1.0) (2017-03-21)

[Full Changelog](https://github.com/typisttech/imposter/compare/08bb86bafbad5d5011156a24d7b32ad883bdf6c0...0.1.0)

**Merged pull requests:**

- Version bump 0.1.0 [\#31](https://github.com/TypistTech/imposter/pull/31) ([TangRufus](https://github.com/TangRufus))



\* *This Changelog was automatically generated by [github_changelog_generator](https://github.com/github-changelog-generator/github-changelog-generator)*
